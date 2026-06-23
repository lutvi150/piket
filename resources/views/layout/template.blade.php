@include('layout.head')

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">Piket</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">Sistem Piket</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            @include('layout.navbar')
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        @include('layout.sidebar_menu')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
        @include('layout.footer')
       
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    @include('layout.script')
</body>
@yield('script')
</html>
