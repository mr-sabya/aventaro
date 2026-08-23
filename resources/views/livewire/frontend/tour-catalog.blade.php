<div class="tour-catalog">
    <div class="tour-filter-panel mb-5 p-4 border rounded bg-light">
        <div class="row g-3">
            <div class="col-xl-3 col-lg-4 col-md-6">
                <label class="form-label" for="tour-search">Search</label>
                <input id="tour-search" type="search" class="form-control" wire:model.live.debounce.350ms="search" placeholder="Tour name or place">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <label class="form-label" for="destination">Destination</label>
                <select id="destination" class="form-select" wire:model.live="destination">
                    <option value="">All destinations</option>
                    @foreach($destinations as $item)
                        <option value="{{ $item->city_id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <label class="form-label" for="date">Travel date</label>
                <input id="date" type="date" class="form-control" wire:model.live="date">
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <label class="form-label" for="min-price">Min price</label>
                <input id="min-price" type="number" min="0" class="form-control" wire:model.live.debounce.350ms="minPrice" placeholder="0">
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <label class="form-label" for="max-price">Max price</label>
                <input id="max-price" type="number" min="0" class="form-control" wire:model.live.debounce.350ms="maxPrice" placeholder="Any">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <label class="form-label" for="duration">Duration</label>
                <input id="duration" class="form-control" wire:model.live.debounce.350ms="duration" placeholder="e.g. 3 Days">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <label class="form-label" for="activity">Activity</label>
                <select id="activity" class="form-select" wire:model.live="activity">
                    <option value="">All activities</option><option value="Adventure">Adventure</option><option value="Culture">Culture &amp; Heritage</option><option value="Food">Food &amp; Cuisine</option><option value="Nature">Nature &amp; Wildlife</option><option value="City">City Discovery</option>
                </select>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <label class="form-label" for="guests">Guests</label>
                <input id="guests" type="number" min="1" max="50" class="form-control" wire:model.live.debounce.350ms="guests" placeholder="Any">
            </div>
            <div class="col-xl-4 d-flex align-items-end justify-content-between gap-3 flex-wrap">
                <p class="mb-0 text-muted" aria-live="polite">
                    Showing {{ $tours->firstItem() ?? 0 }}–{{ $tours->lastItem() ?? 0 }} of {{ $tours->total() }} tours
                </p>
                <button type="button" class="theme-btn theme-btn-2" wire:click="clearFilters" @disabled(!$search && !$destination && !$date && !$minPrice && !$maxPrice && !$duration && !$activity && !$guests)>
                    <span>Clear Filters</span>
                </button>
            </div>
        </div>
        <div class="tour-filter-loading" wire:loading.flex wire:target="search,destination,date,minPrice,maxPrice,duration,activity,guests,clearFilters">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Updating tours…
        </div>
    </div>

    <div class="row g-4 tour-catalog-grid" wire:loading.class="is-loading" wire:target="search,destination,date,minPrice,maxPrice,duration,activity,guests,clearFilters">
        @forelse ($tours as $tour)
            <div class="col-xl-3 col-lg-6 col-md-6" wire:key="catalog-tour-{{ $tour->id }}">
                <div class="tour-box-items mt-0 h-100">
                    <div class="thumb"><a href="{{ route('tour.show', $tour) }}" wire:navigate><img src="{{ \App\Support\Media::url($tour->thumbnail_image) }}" alt="{{ $tour->image_alt ?: $tour->title }}"></a></div>
                    <div class="content">
                        <span>{{ $tour->city?->country?->name ?? $tour->city?->name }}</span>
                        <h4><a href="{{ route('tour.show', $tour) }}" wire:navigate>{{ $tour->title }}</a></h4>
                        <h6>From <span>{{ \App\Support\Money::format($tour->price) }}</span>@if($tour->old_price) <del>{{ \App\Support\Money::format($tour->old_price) }}</del>@endif</h6>
                        <ul class="list"><li><i class="far fa-calendar"></i> {{ $tour->duration }}</li>@if($tour->countries_covered)<li><i class="far fa-flag"></i> {{ $tour->countries_covered }}</li>@endif</ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5"><h3>No tours found</h3><p>Try changing or clearing your filters.</p></div>
        @endforelse
    </div>
    @if ($tours->hasPages())<div class="mt-5">{{ $tours->links() }}</div>@endif
</div>
