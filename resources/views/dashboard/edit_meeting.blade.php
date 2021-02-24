@extends('layouts.profile')

@section('content')
<form method="POST" action="">
    @csrf

    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Title') }}</label>
        <div class="col-md-9">
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $meeting->title) }}" autocomplete="title" autofocus>

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
            <textarea autocomplete="description" autofocus class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description', $meeting->description) }}</textarea>
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
            <input id="max_participant" type="number" class="form-control @error('participant_count') is-invalid @enderror" name="participant_count" value="{{ old('participant_count', $meeting->participant_count) }}" autocomplete="participant_count" autofocus>

            @error('participant_count')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Password') }}</label>
        <div class="col-md-9">
            <input id="name" type="text" class="col-md-2 form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password', $meeting->password) }}" autocomplete="name" autofocus>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Time') }}</label>
        <div class="col-md-5">
            <input id="meeting_date" type="text" class="datepicker form-control @error('meeting_date.date') is-invalid @enderror" name="meeting_date[date]" value="{{ old('time.date', DTime::displayDate($meeting->start_time, 'Y-m-d')) }}" autocomplete="name" autofocus readonly="readonly"   style="background:white;"/>
        </div>
        <div class="col-md-2">
            <select class="form-control @error('meeting_date.time') is-invalid @enderror" name="meeting_date[time]">
                @for( $i=strtotime("12:00") ; $i <= strtotime("23:30"); $i+=1800)
                    <option value="{{date("h:i",$i)}}" {{old('meeting_date.time', DTime::displayTime($meeting->start_time, 'h:i')) == date("h:i",$i) ? "selected" : ""}}>{{date("h:i",$i)}}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control @error('meeting_date.format') is-invalid @enderror" name="meeting_date[format]">
                <option {{old('format', DTime::displayTime($meeting->start_time, 'a')) == 'am' ? "selected" : ""}} value="am">AM</option>
                <option {{old('format', DTime::displayTime($meeting->start_time, 'a')) == 'pm' ? "selected" : ""}} value="pm">PM</option>
            </select>
        </div>
        @error('meeting_date.date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group row align-items-center flex-wrap">
        <label for="name" class="col-md-3 col-form-label">{{ __('Duration') }}</label>
        <div class="row col-md-9 align-items-center">
            <div class="col-md-2">
                <select class="form-control p-1 @error('duration.hr') is-invalid @enderror" name="duration[hr]">
                    @for($i=0; $i<=24; $i++)
                    <option {{old('duration.hr', DTime::getMeetingDuration($meeting->duration)) == $i ? "selected" : ""}} value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
            <span>hr</span>
            <div class="col-md-2">
                <select class="form-control p-1 @error('duration.min') is-invalid @enderror" name="duration[min]">
                    @for($i=0; $i<60; $i+=10)
                    <option {{old('duration.hr', DTime::getMeetingDuration($meeting->meeting_duration, 'min')) == $i ? "selected" : ""}} value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
            <span>min</span>
        </div>
        @error('duration')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group row flex-wrap">
        <label for="guests" class="col-md-3 col-form-label">{{ __('Guests') }}</label>
        <div class="col-md-9">
            <input type="text" value="{{old('guests', $joinees)}}" class="joinee_input form-control @error('guests') is-invalid @enderror" name="guests">
            <p class="text-info"><small>{{__('Add emails seperated by comma(,)')}}</small></p>
            @error('guests')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </div>
</form>
@endsection