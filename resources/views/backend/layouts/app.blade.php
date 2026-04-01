<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template"
        name="description">
    <meta content="admin template, ki-admin admin template, dashboard template, flat admin template, responsive admin template, web app"
        name="keywords">
    <meta content="la-themes" name="author">
    <link href="../assets/images/logo/favicon.png" rel="icon" type="image/x-icon">
    <link href="../assets/images/logo/favicon.png" rel="shortcut icon" type="image/x-icon">
    <title>Ecommerce Dashboard | ki-admin - Premium Admin Template</title>

    <!-- Animation css -->
    <link href="{{ asset('assets/backend/vendor/animation/animate.min.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <!--flag Icon css-->
    <link href="{{ asset('assets/backend/vendor/flag-icons-master/flag-icon.css') }}" rel="stylesheet" type="text/css">

    <!-- tabler icons-->
    <link href="{{ asset('assets/backend/vendor/tabler-icons/tabler-icons.css') }}" rel="stylesheet" type="text/css">

    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.9.0/fonts/remixicon.css"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/font-awesome.css') }}">

    <!-- glight css -->
    <link href="{{ asset('assets/backend/vendor/glightbox/glightbox.min.css') }}" rel="stylesheet">

    <!-- Bootstrap css-->
    <link href="{{ asset('assets/backend/vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <!-- simplebar css-->
    <link href="{{ asset('assets/backend/vendor/simplebar/simplebar.css') }}" rel="stylesheet" type="text/css">

    <!-- App css-->
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet" type="text/css">

    <!-- Responsive css-->
    <link href="{{ asset('assets/backend/css/responsive.css') }}" rel="stylesheet" type="text/css">

    <!-- custom css-->
    <link href="{{ asset('assets/backend/css/custom.css') }}" rel="stylesheet" type="text/css">

</head>

<body>
    <div class="app-wrapper">



        <!-- Menu Navigation starts -->
        <livewire:backend.theme.nav />
        <!-- Menu Navigation ends -->

        <div class="app-content">
            <div class="">

                <!-- Header Section starts -->
                <livewire:backend.theme.header />
                <!-- Header Section ends -->

                <!-- Body main section starts -->
                <main>
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
        <!-- Body main section ends -->


        <!-- tap on top -->
        <div class="go-top">
            <span class="progress-value">
                <i class="ti ti-chevron-up"></i>
            </span>
        </div>

        <!-- Footer Section starts-->
        <livewire:backend.theme.footer />
        <!-- Footer Section ends-->
    </div>

    <!-- modal -->


    <!-- latest jquery-->
    <script data-navigate-once src="{{ asset('assets/backend/js/jquery-3.6.3.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script data-navigate-once src="{{ asset('assets/backend/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- Simple bar js-->
    <script data-navigate-once src="{{ asset('assets/backend/vendor/simplebar/simplebar.js') }}"></script>

    <!-- phosphor js -->
    <script data-navigate-once src="{{ asset('assets/backend/vendor/phosphor/phosphor.js') }}"></script>

    <!-- Glight js -->
    <script data-navigate-once src="{{ asset('assets/backend/vendor/glightbox/glightbox.min.js') }}"></script>

    <script data-navigate-once>
        /* Theme name prepend to localStorage key */
        const themeName = "ki-admin";


        // >>-- 04 Sidebar toggle js --<<
        $(document).on('click', '.header-toggle', function() {
            $("nav").toggleClass("semi-nav");
        });
        $(".toggle-semi-nav").on("click", function() {
            $("nav").removeClass("semi-nav");
        });
    </script>


    <!-- App js-->
    <script data-navigate-once src="{{ asset('assets/backend/js/script.js') }}"></script>

</body>

</html>