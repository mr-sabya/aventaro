<div>
@if ($section || $destinations->isNotEmpty())
    <section class="trending-destinations section-padding fix">
        <div class="container">
            <div class="section-title-area lg-center">
                <div class="section-title">
                    <span class="wow fadeInUp">{{ $section?->subtitle ?? 'Trending Destinations' }}</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">{{ $section?->title ?? 'Trendy Travel Locations' }}</h2>
                </div>
                <a href="{{ $section?->button_url ?: route('destination.index') }}" class="theme-btn theme-btn-2 wow fadeInUp" data-wow-delay=".5s">
                    <span>{{ $section?->button_text ?? 'Explore More' }}</span> <i class="far fa-long-arrow-right"></i>
                </a>
            </div>
            @if ($destinations->isNotEmpty())
                <div class="row">
                    @foreach ($destinations as $destination)
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" wire:key="trending-destination-{{ $destination->id }}">
                            <div class="trending-destinations-card-items">
                                <div class="destinations-img">
                                    <img src="{{ Storage::url($destination->image) }}" alt="{{ $destination->name }}">
                                    <div class="icon"><a href="{{ route('destination.show', $destination) }}" aria-label="View {{ $destination->name }}"><i class="fas fa-arrow-right"></i></a></div>
                                    <ul class="destinations-content"><li class="title"><a href="{{ route('destination.show', $destination) }}">
                                        {{ $destination->name }}@if ($destination->city?->country), {{ $destination->city->country->name }}@endif
                                    </a></li></ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center mb-0">Trending destinations will be available soon.</p>
            @endif
        </div>
    </section>
@endif
</div>
