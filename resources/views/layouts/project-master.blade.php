<!DOCTYPE html>
<html lang="en" dir="rtl" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.ico') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

    <title>@yield('title')</title>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- end Preloader -->

    <div id="main-wrapper">

        @include('layouts.menus.sidebar')

        <div class="page-wrapper">
            <!--  Header Start -->
            @include('layouts.menus.header')

            <!--end header -- >
            <!--earch Bar -->
            @include('layouts.menus.searchbar')

            <!--end Search Bar-->
            <!--  Header End -->

            @include('layouts.menus.topbar')




            <!-- content -->
            @yield('content')
            <!-- end content-->

            <!--btn setting-->
            @include('layouts.menus.setting')
            <!--end btn setting-->

        </div>

        <!-- script -->

        <script>
            function handleColorTheme(e) {
                document.documentElement.setAttribute("data-color-theme", e);
            }
        </script>
        <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
        <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
        <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>

        <!-- solar icons -->
        <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>


        <!--end script-->
</body>

</html>
