<div>
@if ($section || $partners->isNotEmpty())
    <div class="brand-section fix section-padding sect-bg pt-0">
        <div class="container">
            @if ($section?->text)<p class="brand-text wow fadeInUp">{{ $section->text }}</p>@endif
            @if ($partners->isNotEmpty())
                <div class="swiper brand-slider"><div class="swiper-wrapper">
                    @foreach ($partners as $partner)
                        <div class="swiper-slide" wire:key="partner-{{ $partner->id }}"><div class="brand-img text-center">
                            @if ($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer"><img src="{{ Storage::url($partner->image) }}" alt="{{ $partner->name }}"></a>
                            @else
                                <img src="{{ Storage::url($partner->image) }}" alt="{{ $partner->name }}">
                            @endif
                        </div></div>
                    @endforeach
                </div></div>
            @endif
        </div>
    </div>
@endif
</div>
