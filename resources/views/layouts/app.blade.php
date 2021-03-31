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

        <main class="content-main {{Request::is('/') || Request::is('join') ? "container-fluid p-0 homepage" : "container bg-white mt-2 p-3 mb-2"}}">
            @include('layouts.partials.alerts')
            
            @yield('content')
        </main>
    </div>
    @section('htmlfooter')
            @include('layouts.partials.foot')
    @show
</body>
</html>
