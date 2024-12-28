    <!-- Sidebar Start -->
    <aside class="side-mini-panel with-vertical">
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="iconbar">
            <div>
                <div class="mini-nav">
                    <div class="brand-logo d-flex align-items-center justify-content-center">
                        <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                            <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </div>
                    <ul class="mini-nav-ul" data-simplebar>

                        <!-- --------------------------------------------------------------------------------------------------------- -->
                        <!-- Dashboards -->
                        <!-- --------------------------------------------------------------------------------------------------------- -->
                        <li class="mini-nav-item" id="mini-1">
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                                data-bs-placement="right" data-bs-title="Dashboards">
                                <iconify-icon icon="solar:layers-line-duotone" class="fs-7"></iconify-icon>
                            </a>
                        </li>

                        <li>
                            <span class="sidebar-divider lg"></span>
                        </li>

                    </ul>

                </div>
                <div class="sidebarmenu">
                    <div class="brand-logo d-flex align-items-center nav-logo">
                        <a href="{{ url('workspace') }}" class="text-nowrap logo-img">
                            <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Logo" style="width:60px" />
                        </a>

                    </div>
                    <!-- ---------------------------------- -->
                    <!-- Dashboard -->
                    <!-- ---------------------------------- -->
                    <nav class="sidebar-nav" id="menu-right-mini-1" data-simplebar>
                        <ul class="sidebar-menu" id="sidebarnav">
                            <!-- ---------------------------------- -->
                            <!-- Home -->
                            <!-- ---------------------------------- -->
                            <li class="nav-small-cap">
                                <span class="hide-menu">داشبورد</span>
                            </li>
                            <!-- ---------------------------------- -->
                            <!-- Dashboard -->
                            <!-- ---------------------------------- -->


                            <li class="sidebar-item">
                                <a class="sidebar-link" href="" aria-expanded="false">
                                    <iconify-icon icon="solar:screencast-2-line-duotone"></iconify-icon>
                                    <span class="hide-menu">دستگاه من</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" id="get-url" href="{{ url('#') }}" aria-expanded="false">
                                    <iconify-icon icon="simple-line-icons:settings"></iconify-icon>
                                    <span class="hide-menu">تنظیمات</span>
                                </a>
                            </li>




                            <li>
                                <span class="sidebar-divider"></span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </aside>
    <!--  Sidebar End -->
