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
        <form action="{{ route('tour.index') }}" method="GET" class="booking-list-area-1" aria-label="Find your tour">
            <div class="booking-list">
                <div class="icon"><img src="{{ asset('assets/frontend/img/hero/location.png') }}" alt=""></div>
                <div class="content">
                    <h5><label for="home-destination">Destination</label></h5>
                    <div class="form-clt"><div class="form">
                        <select id="home-destination" name="destination" class="single-select w-100">
                            <option value="">Your city or Region</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->city_id }}">{{ $destination->name }}</option>
                            @endforeach
                        </select>
                    </div></div>
                </div>
            </div>
            <div class="booking-list">
                <div class="icon"><img src="{{ asset('assets/frontend/img/hero/location.png') }}" alt=""></div>
                <div class="content">
                    <h5><label for="home-activity">All Activity</label></h5>
                    <div class="form-clt"><div class="form">
                        <select id="home-activity" name="activity" class="single-select w-100">
                            <option value="">Choose Activity</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Culture">Culture &amp; Heritage</option>
                            <option value="Food">Food &amp; Cuisine</option>
                            <option value="Nature">Nature &amp; Wildlife</option>
                            <option value="City">City Discovery</option>
                        </select>
                    </div></div>
                </div>
            </div>
            <div class="booking-list">
                <div class="icon"><img src="{{ asset('assets/frontend/img/hero/location.png') }}" alt=""></div>
                <div class="content">
                    <h5><label for="home-date">Departure Date</label></h5>
                    <div class="form-clt">
                        <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                            <input id="home-date" class="form-control" type="text" name="date" placeholder="Choose Date" autocomplete="off">
                            <span class="input-group-addon" aria-hidden="true"><i class="far fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="booking-list">
                <div class="icon"><img src="{{ asset('assets/frontend/img/hero/location.png') }}" alt=""></div>
                <div class="content">
                    <h5><label for="home-guests">Guest</label></h5>
                    <div class="form-clt"><div class="form">
                        <select id="home-guests" name="guests" class="single-select w-100">
                            <option value="">Your Guest</option>
                            @foreach (range(1, 10) as $guestCount)
                                <option value="{{ $guestCount }}">{{ $guestCount }} {{ Str::plural('Guest', $guestCount) }}</option>
                            @endforeach
                        </select>
                    </div></div>
                </div>
            </div>
            <button type="submit" class="theme-btn"><span>Search <i class="far fa-search"></i></span></button>
        </form>
    </div>
</section>
