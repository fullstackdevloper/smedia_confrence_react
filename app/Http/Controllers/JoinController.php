<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Meetings;
use App\Providers\meetingServiceProvider;

class JoinController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $meeting_id = null)
    {
        $meeting = Meetings::where('meeting_id', '=', $meeting_id)->first();
        $mservice = meetingServiceProvider::init();
        if($meeting_id && !$meeting) {
            return redirect('/join/')->with('error', __('This meeting is invalid. Please enter a valid meeting ID and then join.'));
        }
        
        if($meeting && $mservice->isHost($meeting) && !$mservice->isStarted($meeting)) {
            if($meeting->isPaid) {
                $meeting = $mservice->startMeeting($meeting);
            }else {
                return redirect('/payment/meeting/'.$meeting_id)->with('error', __('You need to make payment before starting this meeting.'));
            }
        }
        $properties = [];
        if(Auth::check()) {
            $properties = [
                'userId' => Auth::user()->guid,
                'username' => Auth::user()->name
            ];
        }
        
        return view('join/join', [ 'meeting' => $meeting, 'properties' => $properties]);
    }
    
    public function meet_me(Request $request, $room_id) {
        if(\Auth::check() && $room_id == \Auth::user()->guid) {
            return view('join/join_meeting_error', [ 'room_id' => $room_id]);
        }
        
        return view('join/join_meeting', [ 'room_id' => $room_id]);
    }
}
