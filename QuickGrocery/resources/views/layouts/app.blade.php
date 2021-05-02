<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'QuickGrocery') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{asset('js/parsley.min.js')}}" defer></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Global Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">

</head>
<body>
@include('inc.compare-product')
    @include('inc.navbar')
    <div id="refresh-whole">
        @yield('inner-header')
    </div>

        @yield('content')

    @include('inc.footer')


    @yield('include-this')
    <div id="script">
    @yield('scripts')
        <script src="{{ asset('js/chart.min.js') }}"></script>
    @if ( Request::segment(1) != 'supplier' && Request::segment(1) != 'storeadmin' && Request::segment(1) != 'customer' && Request::segment(1) != 'systemadmin')
        <script src="{{ asset('js/pages/carts.js') }}"></script>
        @include('inc.compare-modal')
    @endif
    </div>
</body>
</html>
