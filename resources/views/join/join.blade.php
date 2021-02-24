@extends('layouts.app')

@section('content')
@if($meeting)
    @if($meeting->is_started && !$meeting->is_ended)
        @react(['id' => 'videoconfrence', 'props' => ['userId' => Auth::check() ? Auth::user()->guid : null]])
    @elseif($meeting->is_ended)
        <div class="not_started_meeting d-flex flex-column align-items-center text-center mt-5">
            <h3 class="_prompt_title">{{$meeting->title}}</h3>
            <span>{{$meeting->description}}</span>
            <div class="d-flex flex-column">
                <small><b>Date Started: </b>{{DTime::displayFullDate($meeting->original_start_time)}}</small>
                <small><b>Date Ended: </b>{{DTime::displayFullDate($meeting->original_end_time)}}</small>
                <small><b>Meeting Duration: </b>{{DTime::displayMeetingDuration($meeting)}}</small>
            </div>
        </div>
    @else
        <div class="not_started_meeting d-flex flex-column align-items-center text-center mt-5">
            <h3 class="_prompt_title">The meeting has not started</h3>
            <p>If you are the Host then start this meeting <a href="{{url('join/startmeeting/'.$meeting->meeting_id)}}">Here</a></p>
            <p>we will refresh this page after every 5s</p>
            <script>
                setInterval(function(){
                    window.location.reload(1);
                }, 5000);
            </script>
        </div>
    @endif
@else
@react(['id' => 'videoconfrence222', 'props' => []])
@endif
@endsection