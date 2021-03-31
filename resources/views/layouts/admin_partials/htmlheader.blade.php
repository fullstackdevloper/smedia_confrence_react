<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin/admin.js?v=1.0.0', env('REDIRECT_HTTPS')) }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/admin/admin.css?v=1.0.0', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
    <link href="{{ asset('css/admin/ionicons.min.css?v=1.0.0', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
</head>