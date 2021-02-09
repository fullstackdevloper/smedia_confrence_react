<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JoinController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('join/join');
    }
    
    public function meet_me(Request $request, $room_id) {
        if(\Auth::check() && $room_id == \Auth::user()->guid) {
            return view('join/join_meeting_error', [ 'room_id' => $room_id]);
        }
        
        return view('join/join_meeting', [ 'room_id' => $room_id]);
    }
}
