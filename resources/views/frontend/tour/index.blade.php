@extends('frontend.layouts.app')

@section('content')
<!--  Breadcrumb Section Start -->
<div class="breadcrumb-wrapper section-padding  bg-cover" style="background-image: url('assets/frontend/img/breadcrumb-bg.jpg');">
    <div class="container-fluid">
        <div class="page-heading">
            <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                <li>
                    <a href="index.html">
                        Home
                    </a>
                </li>
                <li>
                    <i class="far fa-slash"></i>
                </li>
                <li>
                    Our Tour Listing
                </li>
            </ul>
            <h1 class="wow fadeInUp" data-wow-delay=".5s">Our Tour Listing</h1>
        </div>
    </div>
    <div class="plane-shape float-bob-x">
        <img src="{{ url('assets/frontend/img/breadcrumb-plane.png') }}" alt="img">
    </div>
</div>

<!-- Tour Section Start -->
<section class="tour-section fix section-padding">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/01.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>AUSTRALIA</span>
                        <h4>
                            <a href="tour-details.html">
                                Island Peak Climbing
                            </a>
                        </h4>
                        <h6>From <span>$376</span> <del>$999</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                3 Days / 2 Night
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                3 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/02.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>LOS ANGLES</span>
                        <h4>
                            <a href="tour-details.html">
                                Ocean on the Maldive
                            </a>
                        </h4>
                        <h6>From <span>$995</span> <del>$1048</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                4 Days / 5 Night
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                3 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/03.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>LONDON</span>
                        <h4>
                            <a href="tour-details.html">
                                Short around Pokhara
                            </a>
                        </h4>
                        <h6>From <span>$574</span> <del>$943</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                2 Days / 3 Night
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                3 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/04.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>BANGLADESH</span>
                        <h4>
                            <a href="tour-details.html">
                                Langtang Valley Trekking
                            </a>
                        </h4>
                        <h6>From <span>$678</span> <del>$899</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                1 Week
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                2 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/05.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>WASINGTON</span>
                        <h4>
                            <a href="tour-details.html">
                                France Eiffel Tower
                            </a>
                        </h4>
                        <h6>From <span>$473</span> <del>$199</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                4 Days / 5 Night
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                3 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/06.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>AMERICA</span>
                        <h4>
                            <a href="tour-details.html">
                                Gananoque Islands
                            </a>
                        </h4>
                        <h6>From <span>$345</span> <del>$599</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                9 Days / 8 Night
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                3 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/077.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>FRANCE</span>
                        <h4>
                            <a href="tour-details.html">
                                Paradise, Places
                            </a>
                        </h4>
                        <h6>From <span>$270</span> <del>$399</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                2 Weeks
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                5 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                <div class="tour-box-items mt-0">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/tour/088.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>DHAKA</span>
                        <h4>
                            <a href="tour-details.html">
                                Moscow Red City Land
                            </a>
                        </h4>
                        <h6>From <span>$678</span> <del>$899</del></h6>
                        <ul class="list">
                            <li>
                                <i class="far fa-calendar"></i>
                                4 Days / 5 Night
                            </li>
                            <li>
                                <i class="far fa-flag"></i>
                                3 Countries
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection