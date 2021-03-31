<?php
namespace App\Providers;

use Auth;
use App\Models\Meetings;
use App\Models\Joinees;
use App\Helpers\FormatHelper;
use App\Helpers\DateTimeHelper;
use App\Providers\GoogleServiceProvider;
use App\Helpers\EncryptionHelper;
use App\Models\User;

class meetingServiceProvider {
    
    private $model;
    
    /**
     * The single instance of the class.
     *
     * @var ActivityHub
     * @since 1.0.0
     */
    protected static $_instance = null;
    
    /**
     * constructor
     */
    public function __construct() {
         
    }
    
    /**
     * Main ActivityHub Instance.
     *
     * Ensures only one instance of IsLayouts is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return ActivityHub.
     */
    public static function init() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function getModel() {
        if(is_null($this->model)) {
            $this->model = new Meetings;
        }
        
        return $this->model;
    }
    public function getUserMeetings($filter = 'upcomming') {
        $query = Meetings::query();
        if ($filter == 'upcomming' || $filter == null) {
            $query->where('start_time', '>', DateTimeHelper::getUtcTime());
        }

        if ($filter == 'past') {
            $query->where('start_time', '<', DateTimeHelper::getUtcTime());
        }

        if ($filter == 'personal') {
            $query->where('meeting_id', Auth::user()->personal_meet_id);
        }
        $query->where('host', Auth::user()->id);
        
        return $query->get();
    }
    
    public function getMeeting($meetingId) {
        $meeting = Meetings::where('meeting_id', '=', $meetingId)->with('joinee')->first();
        
        return $meeting;
    }
    
    public function createPersonalMeeting(User $user) {
        $meetingModal = $this->getModel();
        $meetingModal->meeting_id = $user->personal_meet_id;
        $meetingModal->host = $user->id;
        $meetingModal->title = "{$user->name}'s Personal Room";
        $meetingModal->description = "welcome to {$user->name}'s personal room";
        $meetingModal->save();
    }
    
    public function isPersonal(Meetings $meeting) {
        $user = User::find($meeting->host); 
        if($meeting->meeting_id == $user->personal_meet_id) {
            return true;
        }
    }
    
    public function createMeeting($meetingData) {
        $id = Auth::user()->id;
        if(!$id) {
            return false;
        }
        $meetingduration = DateTimeHelper::createMeetingDuration($meetingData['duration']);
        
        $meetingModal = $this->getModel();
        $meetingModal->meeting_id = FormatHelper::generateMettingId();
        $meetingModal->host = $id;
        $meetingModal->title = $meetingData['title'];
        $meetingModal->description = $meetingData['description'];
        $meetingModal->password = $meetingData['password'];
        $meetingModal->start_time = DateTimeHelper::createMeetingTime($meetingData['meeting_date']);
        $meetingModal->meeting_duration = $meetingduration;
        $meetingModal->participant_count = $meetingData['participant_count'];
        if($meetingModal->save()) {
            /* create google meeting */
            $serviceprovider = new GoogleServiceProvider();
            $serviceprovider->setAccessToken(Auth::user()->calendar_token);
            $meetingData['start_time'] = DateTimeHelper::createMeetingTime($meetingData['meeting_date']);
            $meetingData['end_time'] = DateTimeHelper::addDurationInTime($meetingData['start_time'], $meetingduration);
            $meetingData['joinee'] = $this->createJoinee($meetingModal->id, $meetingData['guests']);
            $meetingData['location'] = self::getMeetingLink($meetingModal);
            $meetingData['meeting_id'] = $meetingModal->meeting_id;
            $calendarEventId = $serviceprovider->createEvent($meetingData);
            
            $created_meeting = Meetings::find($meetingModal->id);
            $created_meeting->calendar_event_id = $calendarEventId;
            $created_meeting->save();
            
            return $meetingModal->meeting_id;
        }
    }
    
    public function updateMeeting(Meetings $meetingModal, $meetingData) {
        
        $meetingduration = DateTimeHelper::createMeetingDuration($meetingData['duration']);
        $meetingModal->meeting_id = FormatHelper::generateMettingId();
        $meetingModal->title = $meetingData['title'];
        $meetingModal->description = $meetingData['description'];
        $meetingModal->password = $meetingData['password'];
        $meetingModal->start_time = DateTimeHelper::createMeetingTime($meetingData['meeting_date']);
        $meetingModal->meeting_duration = $meetingduration;
        $meetingModal->participant_count = $meetingData['participant_count'];
        if($meetingModal->save()) {
            $serviceprovider = new GoogleServiceProvider();
            $serviceprovider->setAccessToken(Auth::user()->calendar_token);
            $meetingData['start_time'] = DateTimeHelper::createMeetingTime($meetingData['meeting_date']);
            $meetingData['end_time'] = DateTimeHelper::addDurationInTime($meetingData['start_time'], $meetingduration);
            $meetingData['joinee'] = $this->createJoinee($meetingModal->id, $meetingData['guests']);
            $meetingData['location'] = self::getMeetingLink($meetingModal);
            $meetingData['meeting_id'] = $meetingModal->meeting_id;
            $calendarEventId = $serviceprovider->updateEvent($meetingModal->calendar_event_id, $meetingData);
            
            return $meetingModal->meeting_id;
        }
    }
    
    /**
     * 
     * @param \Stripe\Charge $paymentInformation
     * @param Meetings $meeting
     */
    public function savePaymentDetail(\Stripe\Charge $paymentInformation, Meetings $meeting) {
        if($meeting) {
            $paymentDetail = [
                'id' => $paymentInformation->id,
                'receipt_url' => $paymentInformation->receipt_url
            ];
            $meeting->isPaid = true;
            $meeting->payment_detail = json_encode($paymentDetail);
            
            $meeting->save();
        }
    }
    public function getMeetingLink(Meetings $meeting) {
        $encryptionservice = new EncryptionHelper();
        $encodedPassword = $encryptionservice->encode($meeting->password);
        
        return url('join/'.$meeting->meeting_id."?pass=".$encodedPassword);
    }
    /**
     * parse google joinee
     * @param string $joinee
     * @return array
     */
    private function createJoinee($meetingId, $joinee) {
        $joineeArray = explode(',', $joinee);
        $meetingGuests = [];
        foreach ($joineeArray as $key => $joineeEmail) {
            $meetingGuests[] = ['email' => $joineeEmail];
            $insert = ['meeting_id' => $meetingId, 'email_address' => $joineeEmail];
            Joinees::create($insert);
        }
        
        return $meetingGuests;
    }
    
    /**
     * 
     * @param type $meeting
     */
    public function isHost(Meetings $meeting) {
        if(Auth::check() && $meeting->host == Auth::user()->id) {
            return true;
        }
    }
    
    public function isStarted(Meetings $meeting) {
        return $meeting->is_started;
    }
    public function startMeeting(Meetings $meeting) {
        $meeting->is_started = true;
        $meeting->original_start_time = DateTimeHelper::getUtcTime();
        $meeting->save();
        
        return $meeting;
    }
    
    public function endMeeting(Meetings $meeting) {
        $meeting->is_ended = true;
        $meeting->original_end_time = DateTimeHelper::getUtcTime();
        
        $meeting->save();
        
        return $meeting;
    }
    
    public function deleteMeeting(Meetings $meeting) {
        
        $eventId = $meeting->calendar_event_id;
        if($eventId) {
            $serviceprovider = new GoogleServiceProvider();
            $serviceprovider->setAccessToken(Auth::user()->calendar_token);
            $serviceprovider->deleteEvent($eventId);
        }
        if ($meeting->has('joinee')) {
            $meeting->joinee()->delete();
        }
        $meeting->delete();
    }
}