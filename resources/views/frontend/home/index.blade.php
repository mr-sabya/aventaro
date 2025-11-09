@extends('frontend.layouts.app')

@section('content')
<!-- Hero Section Start -->
<livewire:frontend.components.hero-slider />

<!-- Trending Section Start -->
<livewire:frontend.components.destination-section />

<!-- About Section Start -->
<livewire:frontend.components.about-section />

<!-- Brand Section Start -->
<livewire:frontend.components.brand-section />

<!-- Tour Section Start -->
<section class="tour-section fix section-padding">
    <div class="container">
        <div class="section-title text-center">
            <span class="wow fadeInUp">Featured Places</span>
            <h2 class="wow fadeInUp" data-wow-delay=".3s">Amazing Tour Places</h2>
            <p class="mt-3 mt-mb-0 wow fadeInUp" data-wow-delay=".5s">
                Our attraction passes save you more than buying individual tickets for your tour <br> package
                system. Our attraction passes save you more than.
            </p>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="tour-box-items">
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
                <div class="tour-box-items">
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
                <div class="tour-box-items">
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
                <div class="tour-box-items">
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
                <div class="tour-box-items">
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
                <div class="tour-box-items">
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
                <div class="tour-box-items">
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
                <div class="tour-box-items">
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

<!-- Tour-descover-section Start -->
<section class="tour-descover-section section-padding fix bg-cover"
    style="background-image: url(assets/frontend/img/tour/bg2.jpg);">
    <div class="container">
        <div class="tour-discover-wrapper">
            <div class="row g-4">
                <div class="col-xl-5">
                    <div class="tour-content lg-center">
                        <div class="section-title">
                            <span class="wow fadeInUp">Discover Weekly Travelling</span>
                            <h2 class="wow fadeInUp" data-wow-delay=".3s">Hot deals on <br> select expedition
                                departures</h2>
                            <p class="mt-3 mt-mb-0 wow fadeInUp" data-wow-delay=".5s">
                                Curated destinations and tours that capture the true <br> essence of location,
                                ensuring you experience. Our <br> attraction pass save you more.
                            </p>
                        </div>
                        <div class="tour-button mt-3">
                            <a href="tour.html" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
                                <span>Explore More</span> <i class="far fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="swiper tour-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="tour-card-item">
                                    <div class="tour-image">
                                        <img src="{{ url('assets/frontend/img/tour/29.jpg') }}" alt="img">
                                    </div>
                                    <div class="tour-content">
                                        <h6>From <span>$270</span> $399</h6>
                                        <h4>
                                            <a href="tour-details.html">
                                                Marvel at Majestic Mountains and <br> Lakes in Banff, Canada
                                            </a>
                                        </h4>
                                        <ul>
                                            <li>
                                                <i class="far fa-map-marker-alt"></i>
                                                132, Tic St, Wingston, New York 12401
                                            </li>
                                        </ul>
                                        <div class="list">
                                            <ul>
                                                <li>
                                                    <i class="far fa-calendar"></i>
                                                    4 Days / 5 Night
                                                </li>
                                            </ul>
                                            <div class="star">
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="far fa-star"></i></a>
                                                <span>(30)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-card-item">
                                    <div class="tour-image">
                                        <img src="{{ url('assets/frontend/img/tour/30.jpg') }}" alt="img">
                                    </div>
                                    <div class="tour-content">
                                        <h6>From <span>$270</span> $399</h6>
                                        <h4>
                                            <a href="tour-details.html">
                                                Step Back in Time at Ancient Ruins <br> in Rome, Italy
                                            </a>
                                        </h4>
                                        <ul>
                                            <li>
                                                <i class="far fa-map-marker-alt"></i>
                                                132, Tic St, Wingston, New York 12401
                                            </li>
                                        </ul>
                                        <div class="list">
                                            <ul>
                                                <li>
                                                    <i class="far fa-calendar"></i>
                                                    4 Days / 5 Night
                                                </li>
                                            </ul>
                                            <div class="star">
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="far fa-star"></i></a>
                                                <span>(30)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-card-item">
                                    <div class="tour-image">
                                        <img src="{{ url('assets/frontend/img/tour/31.jpg') }}" alt="img">
                                    </div>
                                    <div class="tour-content">
                                        <h6>From <span>$270</span> $399</h6>
                                        <h4>
                                            <a href="tour-details.html">
                                                Uncover Vibrant Culture and History in Lisbon, Portugal
                                            </a>
                                        </h4>
                                        <ul>
                                            <li>
                                                <i class="far fa-map-marker-alt"></i>
                                                132, Tic St, Wingston, New York 12401
                                            </li>
                                        </ul>
                                        <div class="list">
                                            <ul>
                                                <li>
                                                    <i class="far fa-calendar"></i>
                                                    4 Days / 5 Night
                                                </li>
                                            </ul>
                                            <div class="star">
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="far fa-star"></i></a>
                                                <span>(30)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-card-item">
                                    <div class="tour-image">
                                        <img src="{{ url('assets/frontend/img/tour/30.jpg') }}" alt="img">
                                    </div>
                                    <div class="tour-content">
                                        <h6>From <span>$270</span> $399</h6>
                                        <h4>
                                            <a href="tour-details.html">
                                                Step Back in Time at Ancient Ruins <br> in Rome, Italy
                                            </a>
                                        </h4>
                                        <ul>
                                            <li>
                                                <i class="far fa-map-marker-alt"></i>
                                                132, Tic St, Wingston, New York 12401
                                            </li>
                                        </ul>
                                        <div class="list">
                                            <ul>
                                                <li>
                                                    <i class="far fa-calendar"></i>
                                                    4 Days / 5 Night
                                                </li>
                                            </ul>
                                            <div class="star">
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="far fa-star"></i></a>
                                                <span>(30)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-card-item">
                                    <div class="tour-image">
                                        <img src="{{ url('assets/frontend/img/tour/31.jpg') }}" alt="img">
                                    </div>
                                    <div class="tour-content">
                                        <h6>From <span>$270</span> $399</h6>
                                        <h4>
                                            <a href="tour-details.html">
                                                Uncover Vibrant Culture and History in Lisbon, Portugal
                                            </a>
                                        </h4>
                                        <ul>
                                            <li>
                                                <i class="far fa-map-marker-alt"></i>
                                                132, Tic St, Wingston, New York 12401
                                            </li>
                                        </ul>
                                        <div class="list">
                                            <ul>
                                                <li>
                                                    <i class="far fa-calendar"></i>
                                                    4 Days / 5 Night
                                                </li>
                                            </ul>
                                            <div class="star">
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="fas fa-star"></i></a>
                                                <a href="#"><i class="far fa-star"></i></a>
                                                <span>(30)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-dot4 mt-5">
                        <div class="dot"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--  Marquee Section Start -->
<div class="marquee-section fix section-padding pt-0">
    <div class="marque-wrapper style-2">
        <div class="swiper text-slider">
            <div class="swiper-wrapper slide-transtion">
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Mobile-Friendly Platform</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Eco-Friendly Travel Options</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Group Booking Discounts</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Real-Time Itinerary Updates</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Expert Travel Advisors</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Affordable Travel Deals</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Affordable Travel Deals</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="marque-wrapper style-3">
        <div dir="rtl" class="swiper text-slider-2">
            <div class="swiper-wrapper slide-transtion">
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Secure Online Booking</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Verified Customer Reviews</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>24/7 Customer Support</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Exclusive Travel Packages</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Special Member Discounts</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Local Destination Insights</h3>
                    </div>
                </div>
                <div class="swiper-slide brand-slide-element">
                    <div class="marque-text">
                        <img src="{{ url('assets/frontend/img/marque.png') }}" alt="img">
                        <h3>Affordable Travel Deals</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Team Section Start -->
<section class="team-section-4 section-padding pt-0">
    <div class="container">
        <div class="section-title text-center">
            <span class="wow fadeInUp">Our Team</span>
            <h2 class="wow fadeInUp" data-wow-delay=".3s">Tours Guiding Team</h2>
            <p class="mt-3 mt-mb-0 wow fadeInUp" data-wow-delay=".5s">
                Our attraction passes save you more than buying individual tickets for your tour <br> package
                system. Our attraction passes save you more than.
            </p>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="team-card-items-4">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/team/09.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>Tourist Guide</span>
                        <h3><a href="team-details.html">Michel Smith</a></h3>
                        <div class="social-icon">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-basketball-ball"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                <div class="team-card-items-4">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/team/10.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>Tourist Guide</span>
                        <h3><a href="team-details.html">Arden Smith</a></h3>
                        <div class="social-icon">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-basketball-ball"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                <div class="team-card-items-4">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/team/11.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>Tourist Guide</span>
                        <h3><a href="team-details.html">Clover Lilac</a></h3>
                        <div class="social-icon">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-basketball-ball"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                <div class="team-card-items-4">
                    <div class="thumb">
                        <img src="{{ url('assets/frontend/img/team/12.jpg') }}" alt="img">
                    </div>
                    <div class="content">
                        <span>Tourist Guide</span>
                        <h3><a href="team-details.html">Garrison Hale</a></h3>
                        <div class="social-icon">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-basketball-ball"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--  Top Destination Section Start -->
<section class="top-destination-section-4 section-padding pb-0">
    <div class="container">
        <div class="section-title-area">
            <div class="section-title">
                <span class="wow fadeInUp">Our Top Destination</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">Inspiration for Future Travel</h2>
                <p class="mt-3 mt-mb-0 wow fadeInUp" data-wow-delay=".3s">
                    Our attraction passes save you more than buying individual tickets for <br> your tour package
                    system our attraction passes.
                </p>
            </div>
            <a href="destination.html" class="theme-btn theme-btn-2 wow fadeInUp" data-wow-delay=".5s">
                <span>Explore More</span> <i class="far fa-long-arrow-right"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="destination-feature-box">
                    <div class="icon">
                        <img src="{{ url('assets/frontend/img/icon-01.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>Families Tour</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                <div class="destination-feature-box">
                    <div class="icon bg-2">
                        <img src="{{ url('assets/frontend/img/icon-02.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>Young Adults</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                <div class="destination-feature-box">
                    <div class="icon bg-3">
                        <img src="{{ url('assets/frontend/img/icon-3.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>Seniors Person</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                <div class="destination-feature-box">
                    <div class="icon bg-4">
                        <img src="{{ url('assets/frontend/img/icon-4.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>Bike Tours</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="destination-feature-box">
                    <div class="icon bg-5">
                        <img src="{{ url('assets/frontend/img/icon-5.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>Night Tours</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                <div class="destination-feature-box">
                    <div class="icon bg-6">
                        <img src="{{ url('assets/frontend/img/icon-6.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>Hiking & Trekking</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                <div class="destination-feature-box">
                    <div class="icon bg-7">
                        <img src="{{ url('assets/frontend/img/icon-7.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>Day Trips</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                <div class="destination-feature-box">
                    <div class="icon bg-8">
                        <img src="{{ url('assets/frontend/img/icon-8.svg') }}" alt="icon">
                    </div>
                    <div class="content">
                        <h6>River Cruises</h6>
                        <span><b>5</b> Tours - From <b>$359</b></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="cta-wrapper-4 section-padding bg-cover"
            style="background-image: url('assets/frontend/img/cta/cta-bg-3.jpg');">
            <div class="section-title text-center mb-0">
                <span class="wow fadeInUp">Special Offer</span>
                <h2 class="text-white wow fadeInUp" data-wow-delay=".3s">Grab Up To 39% Off On <br> Your Favorite
                    Destination</h2>
            </div>
            <a href="tour-details.html" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
                <span>Book Now</span> <i class="far fa-long-arrow-right"></i>
            </a>
            <div class="discount-shape float-bob-y">
                <img src="{{ url('assets/frontend/img/cta/discount.png') }}" alt="img">
            </div>
            <div class="bag-shape float-bob-x">
                <img src="{{ url('assets/frontend/img/cta/bag.png') }}" alt="img">
            </div>
            <div class="plane-shape">
                <img src="{{ url('assets/frontend/img/cta/olane-shape.png') }}" alt="img">
            </div>
        </div>
    </div>
</section>

<!--Testimonial Section Start -->
<section class="testimonial-section-4 section-padding">
    <div class="container">
        <div class="section-title-area">
            <div class="section-title">
                <span class="wow fadeInUp">Our Testimonial</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    Real Feedback from Our Happy <br> Travelers Worldwide
                </h2>
            </div>
            <p class="wow fadeInUp" data-wow-delay=".5">Our attraction passes save you more than buying<br>
                individual tickets for your tour package system. Our<br> attraction passes save you.</p>
        </div>
        <div class="swiper testimonial-slider-4">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-box-items-4">
                        <div class="testi-img">
                            <img src="{{ url('assets/frontend/img/testimonial/client-03.png') }}" alt="img">
                        </div>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="icon">
                            <img src="{{ url('assets/frontend/img/testimonial/quote-01.png') }}" alt="icon">
                        </div>
                        <h3>
                            "Our family trip was amazing from start to finish! The itinerary was perfect, the guides
                            were knowledgeable, and the service was excellent. I can’t wait to book our next
                            adventure!"
                        </h3>
                        <div class="client-info">
                            <h4>William Smith</h4>
                            <span>from New York, USA</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-box-items-4">
                        <div class="testi-img">
                            <img src="{{ url('assets/frontend/img/testimonial/client-04.png') }}" alt="img">
                        </div>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="icon">
                            <img src="{{ url('assets/frontend/img/testimonial/quote-01.png') }}" alt="icon">
                        </div>
                        <h3>
                            "Our family trip was amazing from start to finish! The itinerary was perfect, the guides
                            were knowledgeable, and the service was excellent. I can’t wait to book our next
                            adventure!"
                        </h3>
                        <div class="client-info">
                            <h4>Michel John</h4>
                            <span>from New York, USA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Section Start -->
<section class="news-section section-padding section-bg-2">
    <div class="container">
        <div class="section-title text-center">
            <span class="wow fadeInUp" data-wow-delay=".3s">Latest Blog & News</span>
            <h2 class="wow fadeInUp" data-wow-delay=".5s">Latest Travel Insights and <br> Destination Guides</h2>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="news-box-items-4">
                    <div class="news-img">
                        <img src="{{ url('assets/frontend/img/news/news-11.jpg') }}" alt="img">
                        <ul class="post-date">
                            <li>
                                22
                            </li>
                            <li>
                                JAN
                            </li>
                        </ul>
                    </div>
                    <div class="news-content">
                        <ul>
                            <li> <b>By</b> Admin</li>
                            <li><b>23</b> Comments</li>
                        </ul>
                        <h3><a href="news-details.html">The top 10 places to traveling in the world with your
                                family</a></h3>
                        <p>We offer carefully curated destinations and tours that capture the true essence.</p>
                        <a href="news-details.html" class="link-btn">Continue Reading <i
                                class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                <div class="news-box-items-4">
                    <div class="news-img">
                        <img src="{{ url('assets/frontend/img/news/news-12.jpg') }}" alt="img">
                        <ul class="post-date">
                            <li>
                                09
                            </li>
                            <li>
                                May
                            </li>
                        </ul>
                    </div>
                    <div class="news-content">
                        <ul>
                            <li> <b>By</b> Admin</li>
                            <li><b>23</b> Comments</li>
                        </ul>
                        <h3><a href="news-details.html">Enrich Your Mind Envision Your Future Education for
                                Success</a></h3>
                        <p>We offer carefully curated destinations and tours that capture the true essence.</p>
                        <a href="news-details.html" class="link-btn">Continue Reading <i
                                class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                <div class="news-box-items-4">
                    <div class="news-img">
                        <img src="{{ url('assets/frontend/img/news/news-13.jpg') }}" alt="img">
                        <ul class="post-date">
                            <li>
                                08
                            </li>
                            <li>
                                APR
                            </li>
                        </ul>
                    </div>
                    <div class="news-content">
                        <ul>
                            <li> <b>By</b> Admin</li>
                            <li><b>23</b> Comments</li>
                        </ul>
                        <h3><a href="news-details.html">Exploring The Green Spaces Of Realar Residence</a></h3>
                        <p>We offer carefully curated destinations and tours that capture the true essence.</p>
                        <a href="news-details.html" class="link-btn">Continue Reading <i
                                class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Section Start -->
<div class="instagram-section fix">
    <div class="swiper instagram-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="instagram-image">
                    <img src="{{ url('assets/frontend/img/instagram/01.jpg') }}" alt="img">
                    <a href="#" class="icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="instagram-image">
                    <img src="{{ url('assets/frontend/img/instagram/02.jpg') }}" alt="img">
                    <a href="#" class="icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="instagram-image">
                    <img src="{{ url('assets/frontend/img/instagram/03.jpg') }}" alt="img">
                    <a href="#" class="icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="instagram-image">
                    <img src="{{ url('assets/frontend/img/instagram/04.jpg') }}" alt="img">
                    <a href="#" class="icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="instagram-image">
                    <img src="{{ url('assets/frontend/img/instagram/05.jpg') }}" alt="img">
                    <a href="#" class="icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="instagram-image">
                    <img src="{{ url('assets/frontend/img/instagram/06.jpg') }}" alt="img">
                    <a href="#" class="icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection