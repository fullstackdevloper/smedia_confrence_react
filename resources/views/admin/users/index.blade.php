@extends('layouts.admin')

@section('htmlheader_title') Users @endsection
@section('contentheader_title') Users @endsection
@section('contentheader_description') All Users @endsection

@section('headerElems')
<a class="btn btn-success btn-sm pull-right" href="{{url('/admin/users/add')}}">{{__('Add User')}}</a>
@endsection

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
                    <th>{{__('user Id')}}</th> 
                    <th>{{__('Personal Meeting Id')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Role')}}</th>
                    <th>{{__('Created')}}</th>
                    <th>{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>

                   @foreach($users as $key => $user)
                   <tr>
                        <td>#{{$user->id}}</td>
                        <td>{{Format::meetingId($user->personal_meet_id)}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->created_at}}</td>
                        <td class="d-flex flex-row justify-content-around">
                            <a class="btn btn-success btn-xs" href="{{url('/admin/meetings/view/'.$user->id)}}"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-warning btn-xs" href="{{url('/admin/meetings/edit/'.$user->id)}}"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{url('admin/users/delete', ['user_id' => $user->id])}}" class="m-0" onsubmit="return confirm('Are you sure to delete this meeting?')">
                                @csrf
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>
                            </form>
                        </td>
                        </tr>
                    @endforeach 


            </tbody>
        </table>
        <div class="pagination_links text-center">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection