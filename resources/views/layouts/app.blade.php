<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    @stack('styles')
    <!-- Theme style -->
    @vite(['resources/css/app.css'])
</head>
<body class="hold-transition sidebar-mini control-sidebar-push sidebar-collapse">

<div class="wrapper">

    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <x-application-logo />

        <!-- Sidebar -->
        <div class="sidebar">
            @include('layouts.navigation')
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Page Heading -->
        @if (isset($header))
            <div class="content-header">
                <div class="container-fluid">
                    {{ $header }}
                </div>
                <!-- /.container-fluid -->
            </div>
        @endif

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                {{ $slot }}
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    @if (isset($sidebar))
    <aside class="control-sidebar control-sidebar-light">
        <!-- Control sidebar content goes here -->
        <div class="p-3 control-sidebar-content" id="control-sidebar-content">
            {{ $sidebar }}
        </div>
    </aside>
    @endif
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2023 - {{ date('Y') }} <a href="/">Store</a></strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
