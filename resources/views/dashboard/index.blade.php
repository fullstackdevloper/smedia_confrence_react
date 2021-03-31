@extends('layouts.profile')

@section('content')
<div class="row">
    <div class="col-sm-3">
    <h6 class="mb-0">{{__('Full Name')}}</h6>
    </div>
    <div class="col-sm-9 text-secondary">
        {{ Auth::user()->name }}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
        <h6 class="mb-0">{{__('Email')}}</h6>
    </div>
    <div class="col-sm-9 text-secondary">
        {{ Auth::user()->email }}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
        <h6 class="mb-0">{{__('Google Calendar')}}</h6>
    </div>
    <div class="col-sm-9 text-secondary d-flex justify-content-between align-items-center flex-wrap">
        @if(Auth::user()->calendar_account && Auth::user()->calendar_token)
            <span> {{ Auth::user()->calendar_account }} </span>
            <a class="btn btn-primary" href="{{url('dashboard/google_signout')}}">{{__('Sign Out')}}</a>
        @else
            <a class="btn btn-primary" href="{{$authurl}}">{{__('Sign In Google')}}</a>
        @endif
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
        <h6 class="mb-0">{{__('Mobile')}}</h6>
    </div>
    <div class="col-sm-9 text-secondary">
        {{ Auth::user()->phone }}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
        <h6 class="mb-0">{{__('TimeZone')}}</h6>
    </div>
    <div class="col-sm-9 text-secondary">
        {{ App\Models\UserMeta::getUserMeta(Auth::user()->id, 'timezone') }}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
    <h6 class="mb-0">{{__('Personal Meeting ID')}}</h6>
    </div>
    <div class="col-sm-9 text-secondary">
        {{Format::meetingId(Auth::user()->personal_meet_id)}}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
        <h6 class="mb-0">{{__('Personal Meeting url')}}</h6>
    </div>
    <div class="col-sm-9 text-secondary">
        <a target="_blank" href="{{ url('/meet-me/') }}/{{Auth::user()->personal_meet_id}}">{{ url('/meet-me/') }}/{{Auth::user()->personal_meet_id}}</a>
    </div>
</div>
@endsection