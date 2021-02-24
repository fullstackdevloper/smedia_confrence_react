<?php

namespace App\Http\Controllers;

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
        if($meeting && $mservice->isHost($meeting) && !$mservice->isStarted($meeting)) {
            $meeting = $mservice->startMeeting($meeting);
        }
        
        return view('join/join', [ 'meeting' => $meeting]);
    }
    
    public function meet_me(Request $request, $room_id) {
        if(\Auth::check() && $room_id == \Auth::user()->guid) {
            return view('join/join_meeting_error', [ 'room_id' => $room_id]);
        }
        
        return view('join/join_meeting', [ 'room_id' => $room_id]);
    }
}
