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
            <div class="panel panel-default">
                <div class="panel-heading">{{__('Stripe API Keys')}}</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>{{__('Stripe Mode')}}</label>
                            <select id="change_stripe_mode" class="form-control" name="api_settings[stripe_mode]">
                                <option {{(Config::getByKey('stripe_mode') == 'test') ? "selected" : "" }} value="test">{{__('Test')}}</option>
                                <option {{(Config::getByKey('stripe_mode') == 'live') ? "selected" : "" }} value="live">{{__('Live')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>{{__('Meeting Price (USD)')}}</label>
                            <input type="number" class="form-control" placeholder="Meeting Price" name="api_settings[meeting_price]" value="{{Config::getByKey('meeting_price')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>{{__('Currency')}}</label>
                            <select class="form-control" name="api_settings[stripe_currency]">
                                @foreach(Config::getPaymentCurriencies() as $key => $value)
                                <option {{Config::getByKey('stripe_currency') == $key  ? "selected" : ""}} value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                    <div class="live_api_settings {{(Config::getByKey('stripe_mode') == 'test') ? "hidden" : "" }}">
                        <div class="form-group">
                            <label>{{__('Publishable key')}}</label>
                            <input type="text" class="form-control" placeholder="Publishable key" name="api_settings[stripe_publish_key]" value="{{Config::getByKey('stripe_publish_key')}}">
                        </div>
                        <div class="form-group">
                            <label>{{__('Secret key')}}</label>
                            <input type="text" class="form-control" placeholder="Secret Key" name="api_settings[stripe_secret_key]" value="{{Config::getByKey('stripe_secret_key')}}">
                        </div>
                    </div>
                    <div class="test_api_settings {{(Config::getByKey('stripe_mode') == 'test') ? "" : "hidden" }}">
                        <div class="form-group">
                            <label>{{__('Test Publishable key')}}</label>
                            <input type="text" class="form-control" placeholder="Publishable key" name="api_settings[stripe_test_publish_key]" value="{{Config::getByKey('stripe_test_publish_key')}}">
                        </div>
                        <div class="form-group">
                            <label>{{__('Test Secret key')}}</label>
                            <input type="text" class="form-control" placeholder="Secret Key" name="api_settings[stripe_test_secret_key]" value="{{Config::getByKey('stripe_test_secret_key')}}">
                        </div>
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
