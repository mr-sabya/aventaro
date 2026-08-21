<section class="hero-section hero-4">
    @if ($slides->isNotEmpty())
        <div class="array-button">
            <button class="array-prev" type="button" aria-label="Previous slide"><i class="far fa-long-arrow-left"></i></button>
            <button class="array-next" type="button" aria-label="Next slide"><i class="far fa-long-arrow-right"></i></button>
        </div>
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide" wire:key="hero-slide-{{ $slide->id }}">
                        <div class="hero-items">
                            <div class="plane-shape"><img src="{{ asset('assets/frontend/img/hero/new/plane-2.png') }}" alt=""></div>
                            <div class="plane-shape-2"><img src="{{ asset('assets/frontend/img/hero/new/plane-3.png') }}" alt=""></div>
                            <div class="hero-bg bg-cover" style="background-image: url('{{ Storage::url($slide->background_image) }}');"></div>
                            <div class="container">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="hero-content">
                                            @if ($slide->subtitle)<h6 data-animation="fadeInUp" data-delay="1.3s">{{ $slide->subtitle }}</h6>@endif
                                            <h1 data-animation="fadeInUp" data-delay="1.5s">
                                                <span class="shape-text">{{ $slide->title_part_1 }}</span>
                                                <span>{{ $slide->title_part_2 }}</span><br>{{ $slide->title_part_3 }}
                                            </h1>
                                            @if ($slide->description)<p data-animation="fadeInUp" data-delay="1.7s">{{ $slide->description }}</p>@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="hero-items">
            <div class="hero-bg bg-cover" style="background-image: url('{{ asset('assets/frontend/img/hero/04.jpg') }}');"></div>
            <div class="container"><div class="row g-4"><div class="col-lg-12"><div class="hero-content">
                <h6>Tour &amp; Travel Agency</h6>
                <h1><span class="shape-text">Explore</span> The<br>Global World</h1>
                <p>Discover memorable destinations and carefully selected tour experiences.</p>
            </div></div></div></div>
        </div>
    @endif

    <div class="container">
        <div class="booking-list-area">
            <form action="{{ route('tour.index') }}" method="GET" class="booking-list">
                <div class="booking-list-item">
                    <div class="icon"><i class="far fa-search"></i></div>
                    <div class="content"><h5>Find a tour</h5><input type="search" name="search" placeholder="Where do you want to go?"></div>
                </div>
                <button type="submit" class="theme-btn"><span>Search</span> <i class="far fa-long-arrow-right"></i></button>
            </form>
        </div>
    </div>
</section>
