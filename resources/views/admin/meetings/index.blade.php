@extends('layouts.admin')

@section('htmlheader_title') Meetings @endsection
@section('contentheader_title') Meetings @endsection
@section('contentheader_description') All Meetings @endsection

@section('main-content')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="user_meetings" class="table table-bordered">
                <thead>
                    <tr class="success">
                        <th>{{__('Meeting Id')}}</th> 
                        <th>{{__('Title')}}</th>
                        <th>{{__('Start Date')}}</th>
                        <th>{{__('Duration')}}</th>
                        <th>{{__('Started')}}</th>
                        <th>{{__('Calendar')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    
                       @foreach($meetings as $key => $meeting)
                       <tr>
                            <td>{{Format::meetingId($meeting->meeting_id)}}</td>
                            <td>{{$meeting->title}}</td>
                            <td>{{DTime::displayFullDate($meeting->start_time)}}</td>
                            <td>{{DTime::displayMeetingDuration($meeting)}}</td>
                            <td>{{$meeting->is_started ? 'Yes' : 'No'}}</td>
                            <td>{{$meeting->calendar_event_id}}</td>
                            <td class="d-flex flex-row justify-content-around">
                                <a class="btn btn-success btn-xs" href="{{url('/admin/meetings/view/'.$meeting->id)}}"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-warning btn-xs" href="{{url('/admin/meetings/edit/'.$meeting->id)}}"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{url('admin/meetings/delete')}}" class="m-0" onsubmit="return confirm('Are you sure to delete this meeting?')">
                                    <input type="hidden" value="{{$meeting->id}}">
                                    <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                            </tr>
                        @endforeach 
                    
                    
                </tbody>
            </table>
            <div class="pagination_links text-center">
                {{ $meetings->links() }}
            </div>
        </div>
    </div>
@endsection