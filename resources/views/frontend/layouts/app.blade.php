<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php($siteSettings = \App\Models\SiteSetting::query()->first())
    <meta name="author" content="{{ $siteSettings?->site_name ?: 'Aventaro' }}">
    <meta name="description" content="@yield('meta_description', $siteSettings?->tagline ?: 'Travel and tour booking')">
    <!-- ======== Page title ============ -->
    <title>@yield('title', $siteSettings?->site_name ?: 'Aventaro')</title>
    <!--<< Favicon >>-->
    <link rel="shortcut icon" href="{{ $siteSettings?->favicon ? asset('storage/'.$siteSettings->favicon) : asset('assets/frontend/img/favicon.svg') }}">
    <!--<< Bootstrap min.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <!--<< Font Awesome.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/font-awesome.css') }}">
    <!--<< Animate.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}">
    <!--<< Magnific Popup.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}">
    <!--<< MeanMenu.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/meanmenu.css') }}">
    <!--<< Odometer.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/odometer.css') }}">
    <!--<< Swiper Bundle.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper-bundle.min.css') }}">
    <!--<< DatePicker.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/datepickerboot.css') }}">
    <!--<< Nice Select.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select.css') }}">
    <!--<< Main.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}">
    <!--<< Style.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    @livewireStyles
</head>

<body>

    <!-- Preloader Start -->
    <livewire:frontend.theme.preloader />

    <!-- Back To Top start -->
    <button id="back-top" class="back-to-top">
        <i class="fas fa-long-arrow-up"></i>
    </button>

    <!-- Offcanvas Area Start -->
    <livewire:frontend.theme.offcanvas />
    <div class="offcanvas__overlay"></div>

    <!-- Header Section Start -->
    <livewire:frontend.theme.header />

    <!-- Search Section Start -->
    <livewire:frontend.theme.search />

    @yield('content')

    <!-- Footer Section Start -->
    <livewire:frontend.theme.footer />

    <!--<< All JS Plugins >>-->

    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery-3.7.1.min.js') }}"></script>
    <!--<< Bootstrap Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--<< Nice Select Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.nice-select.min.js') }}"></script>
    <!--<< Odometer Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/odometer.min.js') }}"></script>
    <!--<< Appear Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.appear.min.js') }}"></script>
    <!--<< Datepicker Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/bootstrap-datepicker.js') }}"></script>
    <!--<< Swiper Slider Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/swiper-bundle.min.js') }}"></script>
    <!--<< MeanMenu Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.meanmenu.min.js') }}"></script>
    <!--<< Magnific Popup Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <!--<< Wow Animation Js >>-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>
    <!--<< Main.js >>-->
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>

    @livewireScripts

</body>

</html>
