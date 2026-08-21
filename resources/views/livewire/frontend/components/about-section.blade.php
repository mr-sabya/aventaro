<div>
@if ($about)
    <section class="about-section section-padding sect-bg">
        <div class="shape-1"><img src="{{ asset('assets/frontend/img/about/dot-shape.png') }}" alt=""></div>
        <div class="container">
            <div class="about-wrapper">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <div class="about-image wow img-custom-anim-left">
                            <img src="{{ Storage::url($about->main_image) }}" alt="{{ $about->title }}">
                            <div class="about-box float-bob-y"><h2><span class="odometer" data-count="{{ $about->experience_years }}">00</span>+</h2><p>YEARS OF EXPERIENCE</p></div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="about-content">
                            <div class="section-title"><span class="wow fadeInUp">{{ $about->subtitle }}</span><h2 class="wow fadeInUp" data-wow-delay=".3s">{{ $about->title }}</h2></div>
                            <p class="wow fadeInUp mt-4 mt-md-0" data-wow-delay=".5s">{{ $about->description }}</p>
                            @if ($about->quote)<div class="about-sideber wow fadeInUp" data-wow-delay=".3s"><h5>“{{ $about->quote }}”</h5></div>@endif
                            @if (!empty($about->features))
                                <div class="about-icon-items">
                                    @foreach ($about->features as $feature)
                                        <div class="icon-items wow fadeInUp" wire:key="about-feature-{{ $loop->index }}">
                                            <div class="icon"><i class="far fa-check"></i></div><div class="content"><h5>{{ $feature }}</h5></div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if ($about->button_text)
                                <div class="about-button wow fadeInUp" data-wow-delay=".5s"><a href="{{ $about->button_url ?: route('pages.about') }}" class="theme-btn"><span>{{ $about->button_text }}</span> <i class="far fa-long-arrow-right"></i></a></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
</div>
