<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Meetings;
use App\Providers\TwilioServiceProvider;
use App\Helpers\DateTimeHelper;
use App\Providers\meetingServiceProvider;

class MeetingsController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getmeetingdetail(Request $request) {
        $meetingId = $request->meetingId;
        $username = $request->username;
        if ($meetingId) {
            $data = [];
            $meeting = Meetings::where('meeting_id', '=', $meetingId)->first();
            if ($username == 'null' && Auth::check()) {
                $username = Auth::user()->name;
            }

            //$data['token'] = $twilioToken = TwilioServiceProvider::init()->generateToken($username, $meetingId);
            $data['meeting_detail'] = $meeting->toArray();
            $data['user'] = ['name' => $username];
            
            echo json_encode($data); die;
        }
    }
    
    public function generateToken(Request $request) {
        $meetingId = $request->meetingId;
        $username = $request->username;
        
        echo TwilioServiceProvider::init()->generateToken($username, $meetingId);
    }
    
    public function endMeeting (Request $request) {
        $meetingId = $request->meeting_id;
        $mservice = meetingServiceProvider::init();
        $meeting = $mservice->getMeeting($meetingId);
        if(!$meeting) {
            die(json_encode(['status' => 'fail', 'message' => 'invalid meeting']));
        }
        
        if($mservice->isHost($meeting)) {
            $mservice->endMeeting($meeting);
            die(json_encode(['status' => 'success', 'message' => 'meeting ended']));
        }
    }
}
