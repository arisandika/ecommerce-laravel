<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Saintveloes">
    <meta name="keywords" content="@yield('meta_keyword')">
    <meta name="description" content="@yield('meta_description')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/plugins/swiper.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/css/plugins/jquery.fancybox.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/css/plugins/alertify.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/css/plugins/default.min.css') }}" rel="stylesheet" type="text/css">

    @stack('style')

    @livewireStyles
</head>

<body>
    <div class="loader-mask">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
    </div>
    <div id="layout-wrapper">
        @include('layouts.inc.front.svg')
        @include('layouts.inc.front.navbar')
        @include('layouts.inc.front.navbar-mobile')
        <main>
            @yield('content')
            <div class="space-6"></div>
        </main>
    </div>
    @include('layouts.inc.front.footer')

    <!-- App js -->
    <script src="{{ asset('front/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/bootstrap-slider.min.js') }}"></script>

    <script src="{{ asset('front/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/countdown.js') }}"></script>
    <script src="{{ asset('front/js/plugins/jquery.fancybox.js') }}"></script>

    <script src="{{ asset('front/js/theme.js') }}"></script>
    <script src="{{ asset('front/js/alertify.min.js') }}"></script>

    @stack('script')

    @livewireScripts
</body>

</html>
