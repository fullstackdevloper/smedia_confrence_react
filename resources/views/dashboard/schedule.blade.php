@extends('layouts.profile')

@section('content')
@if(!Auth::user()->calendar_token || !Auth::user()->calendar_account)
<div class="alert alert-danger">{{__('Please add google calendar first')}}</div>
@else
<form method="POST" action="{{ route('schedule') }}">
    @csrf

    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Title') }}</label>
        <div class="col-md-9">
            <input id="name" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="name" autofocus>

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Description') }}</label>
        <div class="col-md-9">
            <textarea required autocomplete="description" autofocus class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Max Participants') }}</label>
        <div class="col-md-9">
            <input id="max_participant" type="number" max="10" class="form-control @error('participant_count') is-invalid @enderror" name="participant_count" value="5" required autocomplete="participant_count" autofocus>

            @error('participant_count')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Time') }}</label>
        <div class="col-md-5">
            <input id="meeting_date" type="text" class="datepicker form-control @error('description') is-invalid @enderror" name="time[date]" value="{{ old('description') }}" required autocomplete="name" autofocus readonly="readonly"   style="background:white;"/>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <select class="form-control @error('description') is-invalid @enderror" name="time[time]">
                <option>12:00</option>
                <option>12:30</option>
                <option>01:00</option>
                <option>01:30</option>
                <option>02:00</option>
                <option>03:30</option>
                <option>04:00</option>
                <option>04:30</option>
                <option>05:00</option>
                <option>05:30</option>
                <option>06:00</option>
                <option>06:30</option>
                <option>07:00</option>
                <option>07:30</option>
                <option>08:00</option>
                <option>08:30</option>
                <option>09:00</option>
                <option>09:30</option>
                <option>10:00</option>
                <option>10:30</option>
                <option>11:00</option>
                <option>11:30</option>
            </select>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <select class="form-control @error('description') is-invalid @enderror" name="time[format]">
                <option value="am">AM</option>
                <option value="pm">PM</option>
            </select>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row align-items-center flex-wrap">
        <label for="name" class="col-md-3 col-form-label">{{ __('Duration') }}</label>
        <div class="col-md-2">
            <select class="form-control @error('description') is-invalid @enderror" name="duration[hr]">
                @for($i=0; $i<=24; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <span>hr</span>
        <div class="col-md-2">
            <select class="form-control @error('description') is-invalid @enderror" name="duration[min]">
                @for($i=0; $i<60; $i+=10)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <span>min</span>
    </div>
    <div class="form-group row align-items-center flex-wrap">
        <label for="name" class="col-md-3 col-form-label">{{ __('Guests') }}</label>
        <div class="col-md-9">
            <input type="text" class="joinee_input form-control @error('joinee') is-invalid @enderror" name="joinee"> 
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </div>
</form>
@endif
@endsection