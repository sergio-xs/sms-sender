<!DOCTYPE html>
<html class="loading" lang="{{ app()->getLocale() }}" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name') }}</title>
    <link rel="apple-touch-icon" href="{{ Vite::asset('resources/assets/img/apple-icon-180x180.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ Vite::asset('resources/assets/img/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/css/vendors.min.css') }}">
    {{ $styles }}
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/bootstrap/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/layouts/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/layouts/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/layouts/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/menu/vertical-menu.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/theme/css/style.css') }}">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="">

<!-- BEGIN: Header-->
<x-navbar/>
<!-- END: Header-->

<!-- BEGIN: Main Menu-->
<x-menu :selected="$menuselected"/>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            {{ $slot }}
        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<x-footer></x-footer>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{ Vite::asset('resources/theme/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

{{ $scripts }}

<!-- BEGIN: Theme JS-->
<script src="{{ Vite::asset('resources/theme/menu/app-menu.js') }}"></script>
<script src="{{ Vite::asset('resources/theme/js/app.js') }}"></script>

<script src="{{ Vite::asset('resources/theme/pages/js/log-out.js') }}"></script>
<!-- END: Theme JS-->

<script>
    $(document).ready(function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
    /** Set CSRF at ajax post requests */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
<!-- END: Body-->

</html>
