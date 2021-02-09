<?php
namespace App\Providers;

use Auth;
use App\Models\Meetings;
use App\Helpers\FormatHelper;
use App\Helpers\DateTimeHelper;
use App\Providers\GoogleServiceProvider;

class meetingServiceProvider {
    /**
     * constructor
     */
    public function __construct() {
        
    }
    
    public function createMeeting($meetingData) {
        $id = Auth::user()->id;
        if(!$id) {
            return false;
        }
        $meetingduration = DateTimeHelper::createMeetingDuration($meetingData['duration']);
        
        $meetingModal = new Meetings;
        $meetingModal->meeting_id = FormatHelper::generateMettingId();
        $meetingModal->host = $id;
        $meetingModal->title = $meetingData['title'];
        $meetingModal->description = $meetingData['description'];
        $meetingModal->start_time = DateTimeHelper::createMeetingTime($meetingData['time']);
        $meetingModal->meeting_duration = $meetingduration;
        $meetingModal->participant_count = $meetingData['participant_count'];
        if($meetingModal->save()) {
            /* create google meeting */
            $serviceprovider = new GoogleServiceProvider();
            $serviceprovider->setAccessToken(Auth::user()->calendar_token);

            $meetingData['start_time'] = DateTimeHelper::createMeetingTime($meetingData['time'], false);
            $meetingData['end_time'] = DateTimeHelper::addDurationInTime($meetingData['start_time'], $meetingduration);
            $meetingData['joinee'] = $this->createJoinee($meetingData['joinee']);
            $meetingData['location'] = url('join/'.$meetingModal->meeting_id);
            $meetingData['meeting_id'] = $meetingModal->meeting_id;
            $calendarEventId = $serviceprovider->createEvent($meetingData);
            
            return $meetingModal->meeting_id;
        }
    }
    
    /**
     * parse google joinee
     * @param string $joinee
     * @return array
     */
    private function createJoinee($joinee) {
        $joineeArray = explode(',', $joinee);
        $meetingGuests = [];
        foreach ($joineeArray as $key => $joineeEmail) {
            $meetingGuests[] = ['email' => $joineeEmail];
        }
        
        return $meetingGuests;
    }
}