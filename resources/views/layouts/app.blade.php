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
            @yield('content')
        </main>
    </div>
    @section('htmlfooter')
            @include('layouts.partials.foot')
    @show
</body>
</html>
