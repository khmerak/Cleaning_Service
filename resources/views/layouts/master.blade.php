<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Cleaning</title>
    <link rel="icon" href="{{ asset('logocleaning.png') }}" type="image/x-icon" />
 
    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" --}}
    {{-- href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- Font Awesome Icons -->
    <!-- Font Awesome 6 Free -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <!-- Theme style -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @yield('navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4" style="position: fixed; background-color: #012340;">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('/logocleaning.png') }}" alt="Service Cleaning Logo"
                    class="brand-image" style="opacity: 3,">
                <span class="brand-text text-white">Service Cleaning</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link text-white">
                                <i class="nav-icon fa-solid fa-square-poll-vertical"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('branch') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Branch
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Customer
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product') }}" class="nav-link text-white">
                                <i class="nav-icon fa-solid fa-box-archive"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('employee') }}" class="nav-link text-white">
                                <i class="nav-icon fa fa-user-group"></i>
                                <p>Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('service') }}" class="nav-link text-white">
                                <i class="nav-icon fa fa-bell"></i>
                                <p>Service</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('upload') }}" class="nav-link text-white">
                                <i class="nav-icon fa-regular fa-folder-open"></i>
                                <p>Upload</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user') }}" class="nav-link text-white">
                                <i class="nav-icon fa fa-user"></i>
                                <p>User</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper" id="app">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2025 <a href="#">Developed by Khemrak.</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->




    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @yield('scripts')
</body>


</html>
