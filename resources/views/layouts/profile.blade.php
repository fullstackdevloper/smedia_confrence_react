<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@section('htmlhead')
	@include('layouts.partials.head')
@show
<body>
    <div id="app">
        @section('htmlheader')
            @include('layouts.partials.header')
        @show

        <main class="content-main">
            <div class="container py-4">
                <div class="main-body">
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                                        <div class="mt-3">
                                          <h4>{{ Auth::user()->name }}</h4>
                                          <!--<p class="text-secondary mb-1">Full Stack Developer</p>
                                          <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                                          <button class="btn btn-primary">Follow</button>
                                          <button class="btn btn-outline-primary">Message</button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ url('/schedule') }}">Schedule Meeting</a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ url('/meetings') }}">Meetings</a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ url('/dashboard/settings') }}">Settings</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    @include('layouts.partials.alerts')
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
    </div>
    @section('htmlfooter')
            @include('layouts.partials.foot')
    @show
</body>
</html>
