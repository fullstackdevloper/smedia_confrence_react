<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchedulingController extends Controller
{
    public function schedule() {
        return view('scheduling/schedule');
    }
    
    public function meet_me(Request $request, $room_id) {
        return view('scheduling/join_meeting', [ 'room_id' => $room_id]);
    }
}
