@extends('layouts.profile')

@section('content')
<div class="z-form-row">
    <div class="form-group row">
        <label class="meeting-label col-md-2">{{__('Topic')}}</label>
        <div class="control col-md-10">
            {{$meeting->title}}
        </div>
    </div>
</div>
<div class="z-form-row">
    <div class="form-group row">
        <label class="meeting-label col-md-2">{{__('Description')}}</label>
        <div class="control col-md-10">
            {{$meeting->description}}
        </div>
    </div>
</div>
<div class="z-form-row">
    <div class="form-group row">
        <label class="meeting-label col-md-2">{{__('Time')}}</label>
        <div class="controls col-md-10">
            <div>{{DTime::displayFullDate($meeting->start_time)}}</div>
        </div>
    </div>
</div>
<div class="z-form-row">
    <div class="form-group row">
        <label class="meeting-label col-md-2">{{__('Meeting ID')}}</label>
        <div class="control col-md-10">
            {{Format::meetingId($meeting->meeting_id)}}
        </div>
    </div>
</div>
<div class="z-form-row">
    <div class="form-group row">
        <label class="meeting-label col-md-2">{{__('Passcode')}}</label>
        <div class="controls col-md-10">
            <strong id="displayPassword">{{$meeting->password}}</strong>
        </div>
    </div>
</div>
<!---->
<div class="z-form-row">
    <div class="form-group row">
        <label class="meeting-label col-md-2">{{__('Invite Link')}}</label>
        <div class="controls col-md-10">
            <span class="pull-left">{{\App\Providers\meetingServiceProvider::init()->getMeetingLink($meeting)}}</span>
        </div>
    </div>
</div>
@if($meeting->isPaid)
    <div class="z-form-row">
        <div class="form-group row">
            <label class="meeting-label col-md-2">{{__('Invoice')}}</label>
            <div class="controls col-md-10">
                <span class="pull-left"><a href='{{json_decode($meeting->payment_detail, true)['receipt_url']}}' target="_blank">{{__('View Invoice')}}</a></span>
            </div>
        </div>
    </div>
@endif
<div class="z-form-row">
    <div class="form-group">
        <div class="mt-5 d-flex justify-content-center align-items-center">
            @if(!$meeting->isPaid)
                <a type="button" class="btn btn-primary mr-2" href="{{url('payment/meeting', ['meeting_id' => $meeting->meeting_id])}}">{{__('Payment')}}</a>
            @endif
            <a type="button" class="btn_Start_meeting btn btn-primary mr-2" href="{{Routing::getMeetingStartLink($meeting)}}">{{__('Start')}}</a>
            <a role="button" class="btn btn-primary mr-2" href="{{url('/meeting/edit', ['meeting_id' => $meeting->meeting_id])}}">{{__('Edit')}}</a>
            <a role="button" onclick="$('#meeting_delete_form').submit();" id="btn_Delete_meeting" class="btn btn-danger mr-2" href="javascript:;">{{__('Delete')}}</a>  
            <form method="post" onsubmit="return confirm('Are you sure to delete {{$meeting->title}}?');" id="meeting_delete_form" action="{{url('meeting/delete/'.$meeting->id)}}">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection