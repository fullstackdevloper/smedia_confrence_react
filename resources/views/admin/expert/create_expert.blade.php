@extends("layouts.admin")
@section('htmlheader_title') Expert @endsection
@section('contentheader_title') Expert @endsection
@section('contentheader_description') Add Expert @endsection
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
<div class="mainContent">
  <div class="row">
    <div class="col-md-12">
    <h2>Register</h2>
    <form method="POST" action="{{url('/admin/expert/add')}}" enctype="multipart/form-data">
       @csrf
      <input id="timezones" type="hidden" class="form-group"  name="timezone" value="">

      <div class="form-group">
        <label for="name">{{__('Full Name')}}:</label>
        <input type="text" class="form-control" id="name" name="name" required="required" value="{{ old('name') }}">
      </div>

      <div class="form-group">
        <label for="email">{{__('Email')}}:</label>
        <input type="email" class="form-control" id="email" name="email" required="required|unique:users">
        @error('email')
        <div class="alert alert-danger">{{ 'This Email Already Added' }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">{{__('Password')}}:</label>
        <input type="password" class="form-control" id="password" name="password" >
      </div>

      <div class="form-group">
        <label for="title">{{__('Title')}}:</label>
        <input type="text" class="form-control" id="title" name="title" maxlength="100" value="{{ old('title') }}" required="required">
      </div>

      <div class="form-group">
        <label for="Bio">{{__('Bio')}}:</label>
        <textarea  class="form-control" name="bio" id="bio" rows="4" maxlength="250" cols="50">{{ old('bio') }}</textarea>
      </div>

      <div class="form-group">
        <label for="Bio">{{__('Profile Picture')}}:</label>
        <input id="profilePicture" type="file" class="form-control" name="profile_picture">
      </div>

      <div class="form-group">
        <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
      </div>

    </form>
    </div>
  </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js'></script>
<script type="text/javascript">
  var timezone = jstz.determine();
  document.getElementById("timezones").value = timezone.name();
</script> 
@endsection
