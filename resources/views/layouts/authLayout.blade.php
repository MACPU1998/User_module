<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />


    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.ico') }}" />

    <!-- App css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/styles.css') }}" />
    @yield('headerStyle')
</head>
@section('body')
@show

<body class="account-body accountbg">

    <!-- content -->
    @yield('content')

    <!-- Import Js Files -->

    <script src="{{ URL::asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ URL::asset('assets/js/theme/app.min.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>

</html>
