<div>
@if ($section || $tours->isNotEmpty())
    <section class="tour-descover-section section-padding fix bg-cover"
        @if ($section?->background_image) style="background-image: url('{{ Storage::url($section->background_image) }}');" @endif>
        <div class="container">
            <div class="tour-discover-wrapper">
                <div class="row g-4">
                    <div class="col-xl-5">
                        <div class="tour-content lg-center">
                            <div class="section-title">
                                <span class="wow fadeInUp">{{ $section?->subtitle ?? 'Discover Weekly Travelling' }}</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">{{ $section?->title ?? 'Hot deals on select expedition departures' }}</h2>
                                @if ($section?->description)<p class="mt-3 mt-mb-0 wow fadeInUp" data-wow-delay=".5s">{{ $section->description }}</p>@endif
                            </div>
                            <div class="tour-button mt-3">
                                <a href="{{ $section?->button_url ?: route('tour.index') }}" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
                                    <span>{{ $section?->button_text ?? 'Explore More' }}</span> <i class="far fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        @if ($tours->isNotEmpty())
                            <div class="swiper tour-slider"><div class="swiper-wrapper">
                                @foreach ($tours as $tour)
                                    <div class="swiper-slide" wire:key="hot-deal-tour-{{ $tour->id }}">
                                        <div class="tour-card-item">
                                            <div class="tour-image"><img src="{{ Storage::url($tour->thumbnail_image) }}" alt="{{ $tour->title }}"></div>
                                            <div class="tour-content">
                                                <h6>From <span>{{ \App\Support\Money::format($tour->price) }}</span>
                                                    @if ($tour->old_price)<del>{{ \App\Support\Money::format($tour->old_price) }}</del>@endif
                                                </h6>
                                                <h4><a href="{{ route('tour.show', $tour) }}">{{ $tour->title }}</a></h4>
                                                <ul class="list">
                                                    <li><i class="far fa-calendar"></i> {{ $tour->duration }}</li>
                                                    @if ($tour->countries_covered)<li><i class="far fa-flag"></i> {{ $tour->countries_covered }}</li>@endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div></div>
                        @else
                            <div class="text-center text-white py-5">Hot-deal tours will be available soon.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
</div>
