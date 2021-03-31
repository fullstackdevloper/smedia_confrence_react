@extends("layouts.admin")

@section("contentheader_title", "Configuration")
@section("contentheader_description", "")
@section("section", "Configuration")
@section("sub_section", "")
@section("htmlheader_title", "Configuration")

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
<form action="{{url('admin/settings')}}" method="POST">
    <!-- general form elements disabled -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">GUI Settings</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {{ csrf_field() }}
            <!-- text input -->
            <div class="form-group">
                <label>{{__('Sitename')}}</label>
                <input type="text" class="form-control" placeholder="Site Name" name="settings[site_name]" value="{{Config::getByKey('site_name')}}">
            </div>
            <div class="form-group">
                <label>{{__('Site Description')}}</label>
                <input type="text" class="form-control" placeholder="Description in 140 Characters" maxlength="140" name="settings[site_description]" value="{{Config::getByKey('site_description')}}">
            </div>
            <div class="form-group">
                <label>{{__('Page Size')}}</label>
                <input type="number" class="form-control" placeholder="Pag size" name="settings[default_page_size]" value="{{Config::getByKey('default_page_size')}}">
            </div>
            <div class="form-group">
                <label>{{__('Full Date Format')}}</label>
                <input type="text" class="form-control" placeholder="d m, Y H:i T" name="settings[date_time_format]" value="{{Config::getByKey('date_time_format')}}">
            </div>
            <div class="form-group">
                <label>{{__('Date Format')}}</label>
                <input type="text" class="form-control" placeholder="d m, Y" name="settings[date_format]" value="{{Config::getByKey('date_format')}}">
            </div>
            <div class="form-group">
                <label>{{__('Time Format')}}</label>
                <input type="text" class="form-control" placeholder="h:i:s" name="settings[time_format]" value="{{Config::getByKey('time_format')}}">
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div><!-- /.box-footer -->
    </div><!-- /.box -->
</form>

@endsection
