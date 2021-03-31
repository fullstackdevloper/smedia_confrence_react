<?php

namespace App\Providers;

use Auth;
use App\Models\User;
use App\Helpers\DateTimeHelper;
use App\Models\Configurations;

class GoogleServiceProvider {

    const APPLICATION_NAME = 'Smedia Video Confrence';
    const ACCESS_TYPE = 'offline';

    private $client_id;
    private $client_secret;
    private $access_token;
    private $client;
    private $service;
    private $calendarId;
    private $application_name;

    /**
     * constructor
     */
    public function __construct() {
        $this->client_id = Configurations::getByKey('google_client_id');
        $this->client_secret = Configurations::getByKey('google_client_secret');
        $this->application_name = Configurations::getByKey('site_name');
        $this->calendarId = Auth::user()->calendar_account;
    }

    /**
     * @return \Google_Client
     */
    public function getClient() {
        if (is_null($this->client)) {
            $this->client = new \Google_Client();

            $this->client->setApplicationName($this->application_name);
            $this->client->setClientId($this->client_id);
            $this->client->setClientSecret($this->client_secret);
            $this->client->setRedirectUri(url('/dashboard'));
            $this->client->setAccessType(static::ACCESS_TYPE);
            $this->client->setPrompt('consent');
            $this->client->addScope(\Google_Service_Calendar::CALENDAR);
        }

        return $this->client;
    }

    /**
     * 
     * @return boolean
     */
    public function fetchAccessToken() {
        $code = $_GET['code'];

        if (empty($code))
            return false;

        $this->getClient()->authenticate($code);
        $access_token = $this->getClient()->getAccessToken();

        return json_encode($access_token);
    }

    /**
     * 
     * @return $this
     */
    public function revokeToken() {
        $this->getClient()->revokeToken();

        return $this;
    }
    
    /**
     * 
     * @param type $access_token
     * @param type $checkIfExpired
     * @return $this
     */
    public function setAccessToken($access_token, $checkIfExpired = true) {
        $this->access_token = !is_array($access_token) ? json_decode($access_token, true) : $access_token;

        $this->getClient()->setAccessToken($this->access_token);

        if ($checkIfExpired) {
            $this->checkIfTokenExpired();
        }

        return $this;
    }

    /**
     * check if token is expired
     */
    private function checkIfTokenExpired() {
        if ($this->getClient()->isAccessTokenExpired()) {
            $refresh_token = $this->getClient()->getRefreshToken();
            $this->getClient()->fetchAccessTokenWithRefreshToken($refresh_token);

            $this->access_token = $this->getClient()->getAccessToken();
        }
    }

    /**
     * get google auth url for calendar
     * @param type $redirect
     * @return type
     */
    public function getAuthUrl($redirect = null) {
        $authUrl = $this->getClient()->createAuthUrl();

        if ($redirect) {
            Helper::redirect($authUrl);
        }

        return $authUrl;
    }
    
    /**
     * create a new event in google
     * @param array $eventData
     * @return mixed
     */
    public function createEvent($eventData) {
        try
        {
            $saveEvent = $this->getService()->events->insert( $this->calendarId, $this->getEventObj($eventData), ['sendNotifications' => true] );
            $eventId = $saveEvent->getId();
        }
        catch ( \Exception $e )
        {
            abort('500', __($e->getMessage()));
            //echo "<pre>"; print_r($e->getMessage()); die;
            $eventId = null;
        }
            
        return  $eventId;   
    }
    
    public function updateEvent($eventId, $eventData) {
        try {
            $saveEvent = $this->getService()->events->update( $this->calendarId, $eventId, $this->getEventObj($eventData), ['sendNotifications' => true] );
            
            return $saveEvent->getId();
        } catch (\Exception $e) {
            abort('500', __($e->getMessage()));
            $eventId = null;
        }
    }
    
    /**
     * delete a calendar event
     * @param string $eventId
     */
    public function deleteEvent($eventId) {
        try {
            $saveEvent = $this->getService()->events->delete( $this->calendarId, $eventId);
        } catch (\Exception $e) {
            //abort('500', __($e->getMessage()));
            //$eventId = null;
        }    
    }
    /**
     * create google event data
     * @param array $eventData
     * @return \Google_Service_Calendar_Event
     */
    private function getEventObj($eventData) {
        $parameters = [
            'summary' => $eventData['title'],
            'description' => $eventData['description'],
            'start' => ['dateTime'	=> DateTimeHelper::getUtcTime($eventData['start_time']) ],
            'end' => [ 'dateTime'	=> DateTimeHelper::getUtcTime($eventData['end_time']) ],
            'attendees' => $eventData['joinee'],
            'guestsCanSeeOtherGuests' => true,
            'extendedProperties' => [
                'private' => [
                        'BookneticAppointmentId' => $eventData['meeting_id']
                ]
            ]
        ];
        if(array_key_exists('location', $eventData)) {
            $parameters['location'] = $eventData['location'];
        }
        
        return new \Google_Service_Calendar_Event($parameters);
    }
    /**
     * 
     * @return \Google_Service_Calendar
     */
    public function getService() {
        if (is_null($this->service)) {
            $this->service = new \Google_Service_Calendar($this->getClient());
        }

        return $this->service;
    }
    
    /**
     * get calendar list
     * @return array
     */
    public function getCalendarsList() {
        try {
            $calendarList = $this->getService()->calendarList->listCalendarList([
                'minAccessRole' => 'writer'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $calendarList->getItems();
    }
    
    /**
     * 
     * @param string $calendarAccount
     * @param jsonestring $accessToken
     */
    public function setUserCalendar($calendarAccount, $accessToken) {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->calendar_account = $calendarAccount;
        $user->calendar_token = $accessToken;
        $user->save();
    }
    
    /**
     * remove user calendar
     */
    public function removeUserCalendar() {
        $id = Auth::user()->id;
        if(!$id) {
            return false;
        }
        
        $user = User::find($id);
        $user->calendar_account = null;
        $user->calendar_token = null;
        $user->save();
        
        return true;
    }
}
