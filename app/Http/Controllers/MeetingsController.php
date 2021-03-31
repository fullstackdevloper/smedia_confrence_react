<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Meetings;
use App\Providers\TwilioServiceProvider;
use App\Helpers\FormatHelper;
use App\Providers\meetingServiceProvider;

class MeetingsController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getmeetingdetail(Request $request) {
        $meetingId = FormatHelper::removeSpaces($request->meetingId);
        $username = $request->username;
        if ($meetingId) {
            $data = [];
            $meeting = Meetings::where('meeting_id', '=', $meetingId)->first();
            if($meeting) {
                if ($username == 'null' && Auth::check()) {
                    $username = Auth::user()->name;
                }

                //$data['token'] = $twilioToken = TwilioServiceProvider::init()->generateToken($username, $meetingId);
                $data['status'] = 'success';
                $data['meeting_detail'] = $meeting->toArray();
                $data['user'] = ['name' => $username];

                echo json_encode($data); die;
            }else {
                echo json_encode(['status' => 'fail', 'message' => __('Invalid Meeting')]);
            }
        }
    }
    
    public function generateToken(Request $request) {
        $meetingId = FormatHelper::removeSpaces($request->meetingId);
        $username = $request->username;
        $meeting = Meetings::where('meeting_id', '=', $meetingId)->first(); 
        if($meeting) {
            if($meeting->isPaid) {
                $token = TwilioServiceProvider::init()->generateToken($username, $meeting->title);
                echo json_encode(['status' => 'success', 'token' => $token]);
                die;
            }else {
                echo json_encode(['status' => 'fail', 'message' => __("You can join this meeting. Please ask the Host to make payment.")]);
                die;
            }
        }else {
            echo json_encode(['status' => 'fail', 'message' => "Invalid Meeting"]);
            die;
        }
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
