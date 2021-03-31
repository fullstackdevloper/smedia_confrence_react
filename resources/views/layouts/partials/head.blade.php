<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js?v=1.0.0', env('REDIRECT_HTTPS')) }}" defer></script>
    <script src="{{ asset('js/jquery.min.js?v=3.5.1', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js?v=3.5.1', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/global.js?v=1.0.0', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.min.js?v=1.0.0', env('REDIRECT_HTTPS')) }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css?v=1.0.0', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css?v=1.0.0', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css?v=1.0.0', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
</head>