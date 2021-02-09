<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Providers\meetingServiceProvider;
use App\Providers\GoogleServiceProvider;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $calendarService = new \App\Providers\GoogleServiceProvider;
        $url = $calendarService->getAuthUrl();
        if(isset($_GET['code'])) {
            $accesstoken = $calendarService->fetchAccessToken();
            $calendarService->setAccessToken($accesstoken);
            $calendarAccounts = $calendarService->getCalendarsList();
            $firstCalender = $calendarAccounts[0]->id;
            $calendarService->setUserCalendar($firstCalender, $accesstoken);
            
            return redirect('/dashboard');
        }
        return view('dashboard/index', ['authurl' => $url]);
    }
    
    public function google_signout() {
        $calendarService = new \App\Providers\GoogleServiceProvider;
        $calendarService->removeUserCalendar();
            
        return redirect('/dashboard');
    }
    public function create_meeting() {
        return view('dashboard/create_meeting');
    }
    
    public function schedule(Request $request) {
        $input = $request->all();
        if($input){
            $meetingService = new meetingServiceProvider();
            $meetingId = $meetingService->createMeeting($input);
            if($meetingId) {
                return redirect('/schedule');
            }
        }
        
        return view('dashboard/schedule');
    }
    
    public function meetings() {
        return view('dashboard/meetings');
    }
    
    public function settings () {
        return view('dashboard/settings');
    }
}
