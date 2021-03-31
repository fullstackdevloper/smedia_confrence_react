@extends('layouts.profile')

@section('content')
<div>
    <ul class="navbar-nav d-flex flex-row nav-pills">
        <!-- Authentication Links -->
        <li class="nav-item pr-2">
            <a class="p-2 nav-link {{$filter == 'upcomming' || $filter == '' ? 'active' : ''}}" href="{{url('meetings', ['filter' => 'upcomming'])}}">Upcomming</a>
        </li>
        <li class="nav-item pr-2">
            <a class="p-2 nav-link {{$filter == 'past' ? 'active' : ''}}" href="{{url('meetings', ['filter' => 'past'])}}">Past</a>
        </li>
        <li class="nav-item pr-2">
            <a class="p-2 nav-link {{$filter == 'personal' ? 'active' : ''}}" href="{{url('meetings', ['filter' => 'personal'])}}">Personal</a>
        </li>
    </ul>
    <div class="user_meetings mt-3">
        @if($meetings->count())
            @foreach($meetings as $meeting)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-9 p-0 d-flex flex-column">
                                    <h5 class="card-title">{{$meeting->title}}</h5>
                                    <span class="card-text">{{$meeting->description}}</span>
                                    <div class="start_time">
                                        <span>
                                            <i class="fa fa fa-calendar"></i>
                                            @if($filter == 'past')
                                                <span>{{DTime::displayFullDate($meeting->original_end_time)}}</span>
                                            @else
                                                <span>{{DTime::displayFullDate($meeting->start_time)}}</span>
                                            @endif
                                        </span>
                                        <span>
                                            <i class="fa fa-clock-o"></i>
                                            <span>{{DTime::displayMeetingDuration($meeting, $filter)}}</span>
                                        </span>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{url('meetings', ['meeting_id' => $meeting->meeting_id])}}" class="btn btn-primary btn-block">View</a>
                                    <a href="{{Routing::getMeetingStartLink($meeting)}}" class="btn btn-primary btn-block">Start</a>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        <div class="alert alert-info">There is no data for selected filters.</div>
        @endif
    </div>
</div>
@endsection