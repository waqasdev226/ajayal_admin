<!DOCTYPE html>

<html
    lang="ar"
    class="light-style layout-navbar-fixed layout-menu-fixed"
    dir="rtl"
    data-theme="theme-default"
    data-assets-path="../../assets/"
    data-template="vertical-menu-template-no-customizer">
<head>
    @include('partial.header')
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include('partial.menu')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('partial.header_action')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            @yield('content')
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

@include('partial.footer')
</body>
</html>

