<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="{{ asset('assets/images/logo-icon-16x16.webp') }}" sizes="16x16">
    <title>@yield('title', 'Default Tilte')</title>
    <meta name="language" content="Arabic" />
    <meta name="title" content="@yield('title', 'العنوان الافتراضي')" />
    <meta name="description" content="@yield('description', 'مؤسسة الشرق الأوسط للنشر العلمي')" />
    <meta name="keywords" content="@yield('keywords', 'مؤسسة, الشرق, الأوسط, للنشر, العلمي')" />
    <meta name="application-name" content="{{ env('APP_NAME') }}">
    <meta property="og:title" content="@yield('title', 'Default Tilte')">
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:url" content="@yield('url', env('APP_URL'))">
    <meta property="og:locale" content="ar_AR">
    <meta property="og:locale:alternate" content="ar_AR">
    <meta property="og:description" content="@yield('description', '')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:image" content="@yield('image', asset('assets/images/meta-image-defualt.jpg'))">
    <meta property="og:image:alt" content="@yield('title', 'Default Tilte')" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:data1" content="{{ env('APP_NAME') }}" />
    <meta property="twitter:image" content="@yield('image', asset('assets/images/meta-image-defualt.jpg'))" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl_carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl_carousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" /> @yield('css')
    <style>
        @media(max-width:768px){
            #menu{display: none}
        }
    </style>
    @if (!isset($enTemplate))
        <link rel="stylesheet" href="{{ asset('assets/css/rtl/rtl.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}" />
    @if (isset($ads))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8640427261089579"
                crossorigin="anonymous"></script>
    @endif
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137036977-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-137036977-2');
    </script>
</head>

<body>
    @if (isset($journal))
        @include('main.layouts.journal-navbar')
    @else
        @include('main.layouts.navbar')
    @endif @yield('content')@include('main.layouts.footer')
    <script src="{{ asset('assets/plugins/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/owl_carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.fittext.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-validate-message-ar.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.form.min.js') }}"></script>@yield('js')
    <script src="{{ asset('assets/js/validation.js') }}"></script>
    <script src="{{ asset('assets/js/file-input.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    <script src="{{ asset('assets/js/plugin.js') }}"></script>
    @if (session()->has('success_email_verification'))
        <script>
            toastr.options.timeOut = 4000;
            toastr.options.progressBar = true;
            toastr.success("{{ session()->get('success_email_verification') }}");
        </script>
        @endif @if (session()->has('deleteMessage'))
            <script>
                toastr.options.timeOut = 1500;
                toastr.options.progressBar = true;
                toastr.success("{{ session()->get('deleteMessage') }}");
            </script>
        @endif
</body>

</html>
