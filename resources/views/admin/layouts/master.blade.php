<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" />
    <!-- animate -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @yield('css')
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/main.css') }}?v<?php echo time(); ?>" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/aside.css') }}?v<?php echo time(); ?>" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/global.css') }}?v<?php echo time(); ?>" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/rtl/rtl.css') }}?v<?php echo time(); ?>" />

    <title>@yield('title','Default Tilte')</title>
</head>

<body>

    @if (isset($getSpinner))
        <div class="load-overlay  d-flex justify-content-center align-items-center">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
            </div>
        </div>
    @endif

    <?php
        if(!isset($hideAside)){
    ?>

    @include('admin.layouts.navbar')
    @include('admin.layouts.aside')
    
    <?php
        }
    ?>

    <div class="container-fluid mt-2 mb-5">
        <!-- Navbar -->
        @yield('content')
        <!-- Content -->
    </div>


    <button id="backToTopButton"><i class="fas fa-arrow-up"></i></button>





    <script src="{{ asset('assets/plugins/fontawesome/all.min.js') }}"></script>
    <!-- jquery -->
    <script src="{{ asset('assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.lazy.min.js') }}"></script>

    <!-- popper-->
    <script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
    <!-- bootstrap-->
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!-- toastr-->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- jquery.fittext -->
    <script src="{{ asset('assets/plugins/jquery/jquery.fittext.js') }}"></script>
    <!-- jquery.validate -->
    <script src="{{ asset('assets/plugins/jquery/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-validate-message-ar.js') }}"></script>
    <!-- jquery.form -->
    <script src="{{ asset('assets/plugins/jquery/jquery.form.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>


    <!-- Script -->
    <script src="{{ asset('admin-assets/js/validate.js') }}?v<?php echo time(); ?>"></script>
    <script src="{{ asset('admin-assets/js/aside.js') }}"></script>
    <script src="{{ asset('assets/js/file-input.js') }}?v<?php echo time(); ?>"></script>
    <script src="{{ asset('admin-assets/js/main.js') }}?v<?php echo time(); ?>"></script>
    <script src="{{ asset('admin-assets/js/requests.js') }}?v<?php echo time(); ?>"></script>
    <script src="{{ asset('admin-assets/js/plugin.js') }}?v<?php echo time(); ?>"></script>
    @yield('js')

</body>

</html>
