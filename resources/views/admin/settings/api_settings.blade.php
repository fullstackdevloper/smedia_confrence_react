@extends("layouts.admin")

@section("contentheader_title", "Api Configuration")
@section("contentheader_description", "")
@section("section", "Api Configuration")
@section("sub_section", "")
@section("htmlheader_title", "Api Configuration")

@section("headerElems")
@endsection

@section("main-content")

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{url('admin/settings/apisettings')}}" method="POST">
    <!-- general form elements disabled -->
    <div class="box box-warning">
        <!-- /.box-header -->
        <div class="box-body">
            {{ csrf_field() }}
            <div class="panel panel-default">
                <div class="panel-heading">{{__('Google API Keys')}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__('Client Id')}}</label>
                        <input type="text" class="form-control" placeholder="google client id" name="api_settings[google_client_id]" value="{{Config::getByKey('google_client_id')}}">
                    </div>
                    <div class="form-group">
                        <label>{{__('Secret')}}</label>
                        <input type="text" class="form-control" placeholder="google client secret" name="api_settings[google_client_secret]" value="{{Config::getByKey('google_client_secret')}}">
                    </div>
                </div>
                
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">{{__('Twilio API Keys')}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__('Account Sid')}}</label>
                        <input type="text" class="form-control" placeholder="Account Sid" name="api_settings[twilio_account_sid]" value="{{Config::getByKey('twilio_account_sid')}}">
                    </div>
                    <div class="form-group">
                        <label>{{__('API Key')}}</label>
                        <input type="text" class="form-control" placeholder="API Key" name="api_settings[twilio_api_key]" value="{{Config::getByKey('twilio_api_key')}}">
                    </div>
                    <div class="form-group">
                        <label>{{__('Secret')}}</label>
                        <input type="text" class="form-control" placeholder="Api Secret" name="api_settings[twilio_api_secret]" value="{{Config::getByKey('twilio_api_secret')}}">
                    </div>
                </div>
                
            </div>
            <!-- text input -->
            
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div><!-- /.box-footer -->
    </div><!-- /.box -->
</form>

@endsection
