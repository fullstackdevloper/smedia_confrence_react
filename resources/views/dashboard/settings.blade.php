@extends('layouts.profile')

@section('content')
<form method="POST" action="{{ route('settings') }}">
    @csrf
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Timezone') }}</label>
        <div class="col-md-9">
            <select class="form-control @error('settings.timezone') is-invalid @enderror" name="settings[timezone]">
                {{DTime::getAllTimeZones()}}
            </select>
            @error('title')
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