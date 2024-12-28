@include('admin.layout.header')

@include('admin.layout.sidebar')

        <!-- Layout container -->
        <div class="layout-page">


          @include('admin.layout.nav_header')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                @include('admin.layout.breadcrumb')
                <div class="row">
                    <!-- Content -->
                    @yield('content')

            <!-- / Content -->
                </div>
            </div>
            @include('admin.layout.footer_content')
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->

@include('admin.layout.footer')
