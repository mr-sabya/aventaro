@extends('frontend.layouts.app')
@section('title','Aventaro | Travel & Tour Booking')
@section('meta_description','Discover curated tours, trusted guides, and memorable destinations with Aventaro.')

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
<livewire:frontend.components.tour-section />

<!-- Tour-descover-section Start -->
<livewire:frontend.components.discover-section />

<!--  Marquee Section Start -->
<livewire:frontend.components.homepage-content />
@if (false)
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
                        <h3><a href="{{ route('pages.about') }}">Michel Smith</a></h3>
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
                        <h3><a href="{{ route('pages.about') }}">Arden Smith</a></h3>
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
                        <h3><a href="{{ route('pages.about') }}">Clover Lilac</a></h3>
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
                        <h3><a href="{{ route('pages.about') }}">Garrison Hale</a></h3>
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
            <a href="{{ route('destination.index') }}" class="theme-btn theme-btn-2 wow fadeInUp" data-wow-delay=".5s">
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
            <a href="{{ route('tour.index') }}" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
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
                        <h3><a href="{{ route('news.index') }}">The top 10 places to traveling in the world with your
                                family</a></h3>
                        <p>We offer carefully curated destinations and tours that capture the true essence.</p>
                        <a href="{{ route('news.index') }}" class="link-btn">Continue Reading <i
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
                        <h3><a href="{{ route('news.index') }}">Enrich Your Mind Envision Your Future Education for
                                Success</a></h3>
                        <p>We offer carefully curated destinations and tours that capture the true essence.</p>
                        <a href="{{ route('news.index') }}" class="link-btn">Continue Reading <i
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
                        <h3><a href="{{ route('news.index') }}">Exploring The Green Spaces Of Realar Residence</a></h3>
                        <p>We offer carefully curated destinations and tours that capture the true essence.</p>
                        <a href="{{ route('news.index') }}" class="link-btn">Continue Reading <i
                                class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif

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
