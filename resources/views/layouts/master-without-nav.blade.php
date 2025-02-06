<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" card-layout="" data-bs-theme="light">

<head>

    <meta charset="utf-8" />
    <title>@yield('title') | philia </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Philia" name="description" />
    <meta content="Philia" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    @include('layouts.head-css')
</head>

@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>
