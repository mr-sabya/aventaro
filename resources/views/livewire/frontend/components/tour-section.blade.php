<div>
@if ($section || $tours->isNotEmpty())
    <section class="tour-section fix section-padding">
        <div class="container">
            <div class="section-title text-center">
                <span class="wow fadeInUp">{{ $section?->subtitle ?? 'Featured Places' }}</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">{{ $section?->title ?? 'Amazing Tour Places' }}</h2>
                @if ($section?->description)<p class="mt-3 mt-mb-0 wow fadeInUp" data-wow-delay=".5s">{{ $section->description }}</p>@endif
            </div>
            @if ($tours->isNotEmpty())
                <div class="row">
                    @foreach ($tours as $tour)
                        <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" wire:key="featured-tour-{{ $tour->id }}">
                            <div class="tour-box-items">
                                <div class="thumb"><img src="{{ Storage::url($tour->thumbnail_image) }}" alt="{{ $tour->title }}"></div>
                                <div class="content">
                                    <span>{{ $tour->city?->country?->name ?? $tour->city?->name ?? 'Tour' }}</span>
                                    <h4><a href="{{ route('tour.show', $tour) }}">{{ $tour->title }}</a></h4>
                                    <h6>From <span>${{ number_format((float) $tour->price, 2) }}</span>
                                        @if ($tour->old_price)<del>${{ number_format((float) $tour->old_price, 2) }}</del>@endif
                                    </h6>
                                    <ul class="list">
                                        <li><i class="far fa-calendar"></i> {{ $tour->duration }}</li>
                                        @if ($tour->countries_covered)<li><i class="far fa-flag"></i> {{ $tour->countries_covered }}</li>@endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4"><a href="{{ route('tour.index') }}" class="theme-btn"><span>View All Tours</span> <i class="far fa-long-arrow-right"></i></a></div>
            @else
                <p class="text-center mb-0">Featured tours will be available soon.</p>
            @endif
        </div>
    </section>
@endif
</div>
