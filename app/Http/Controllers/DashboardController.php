<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Providers\meetingServiceProvider;
use App\Helpers\EncryptionHelper;
use App\Models\Meetings;
use App\Models\UserMeta;

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
            $model= $meetingService->getModel();
            if($model->validate($input)) {
                $meetingId = $meetingService->createMeeting($input);
                if($meetingId) {
                    return redirect('/meetings/'.$meetingId);
                }
            }else {
                return Redirect::back()->withErrors($model->errors())->withInput($input);
            }
        }
        
        $meetingPassword = EncryptionHelper::createPassword();
                
        return view('dashboard/schedule', ['password' => $meetingPassword]);
    }
    
    public function meetings(Request $request, $meeting_id = null) {
        if($meeting_id && is_numeric($meeting_id)) {
            $meeting = meetingServiceProvider::init()->getMeeting($meeting_id);
            
            return view('dashboard/view_meeting', ['meeting' => $meeting]);
        }

        $meetings = meetingServiceProvider::init()->getUserMeetings($meeting_id);
        
        return view('dashboard/meetings', ['meetings' => $meetings, 'filter' => $meeting_id]);
    }
    
    public function editMeeting(Request $request, $meeting_id = null) {
        $meeting = meetingServiceProvider::init()->getMeeting($meeting_id);
        $input = $request->all();
        $meetingService = new meetingServiceProvider();
        if(!$meetingService->isHost($meeting)) {
            abort('403', __("You are not allowed to edit this meeting"));
        }
        
        if($input){
            $model= $meetingService->getModel();
            if($model->validate($input)) {
                $meetingId = $meetingService->updateMeeting($meeting, $input);
                if($meetingId) {
                    return redirect('/meetings/'.$meetingId);
                }
            }else {
                return Redirect::back()->withErrors($model->errors())->withInput($input);
            }
        }
        $joinees = implode(",", array_column($meeting->joinee->toArray(), "email_address"));
        
        return view('dashboard/edit_meeting', ['meeting' => $meeting, 'joinees' => $joinees]);
    }
    
    public function delete_meeting(Request $request, $meeting_id = null) {
        $meeting = Meetings::findOrFail($meeting_id);
        $isDeleted = meetingServiceProvider::init()->deleteMeeting($meeting);
        
        return redirect('/meetings');
    }
    
    public function settings (Request $request) {
        $input = $request->all();
        if($input) {

            foreach($input['settings'] as $key => $value) {
                UserMeta::updateUserMeta(Auth::user()->id, $key, $value);
            }
            
            return redirect('/dashboard/settings');
        }
        
        return view('dashboard/settings');
    }
}
