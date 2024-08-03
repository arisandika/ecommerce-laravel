<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="SaintShop Admin Dashboard">
    <meta property="og:description" content="Seamless e-commerce management with SaintShop's admin dashboard.">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    @stack('style')

    @livewireStyles
</head>

<body data-sidebar="light">
    <div id="layout-wrapper">
        <!-- Navbar -->
        @include('livewire.layouts.inc.admin.navbar')
        <!-- Sidebar -->
        @include('livewire.layouts.inc.admin.sidebar')
        <!-- Main Content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluids">
                    <!-- Page Title -->
                    @include('livewire.layouts.inc.admin.page-title')
                    <!-- Content -->
                    @yield('content')
                    @yield('content-detail')
                </div>
            </div>
            <!-- Footer -->
            @include('livewire.layouts.inc.admin.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Dashboard Init -->
    <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('script')

    @livewireScripts
</body>

</html>
