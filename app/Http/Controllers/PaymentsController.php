<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\meetingServiceProvider;
use App\Providers\StripeServiceProvider;

class PaymentsController extends Controller
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
    
    /**
     * make meeting payment
     * @param Request $request
     * @param type $meeting_id
     */
    public function meeting(Request $request, $meeting_id) {
        $meetingService = meetingServiceProvider::init();
        $meeting = $meetingService->getMeeting($meeting_id);
        if(!$meeting) {
            abort('404');
        }
        if($meeting->isPaid) {
            //http://localhost:8000/payment/meeting/3356641599
            return redirect('/meetings/'.$meeting_id)->with('warning', __('This meeting is already paid.'));
        }
        $input = $request->all();
        if($input) {
            $token = $input['token'];
            if($token) {
                $paymentInformation = StripeServiceProvider::init()->createMeetingCharge($token, $meeting);
                if($paymentInformation->status == 'succeeded' && $paymentInformation->paid) {
                    $meetingService->savePaymentDetail($paymentInformation, $meeting);
                    return redirect('/meetings/'.$meeting_id)->with('success', __('Your payment is successfull.'));
                }else {
                    return Redirect::back()->with('error', __('Your payment is failed. Please try again'));
                }
            }
        }
        
        return view('payments/meeting', ['meeting' => $meeting]);
    }
}
