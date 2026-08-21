@extends('frontend.layouts.app')

@section('content')
<div class="breadcrumb-wrapper section-padding bg-cover" style="background-image: url('{{ asset('assets/frontend/img/breadcrumb-bg.jpg') }}');">
    <div class="container-fluid"><div class="page-heading">
        <ul class="breadcrumb-items"><li><a href="{{ route('home') }}">Home</a></li><li><i class="far fa-slash"></i></li><li>Tour Packages</li></ul>
        <h1>Tour Packages</h1>
    </div></div>
</div>

<section class="tour-section fix section-padding">
    <div class="container">
        <form method="GET" action="{{ route('tour.index') }}" class="row g-3 mb-5 p-4 border rounded bg-light">
            <div class="col-lg-3"><label class="form-label" for="tour-search">Search</label><input id="tour-search" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tour name or place"></div>
            <div class="col-lg-3"><label class="form-label" for="destination">Destination</label><select id="destination" class="form-select" name="destination"><option value="">All destinations</option>@foreach($destinations as $item)<option value="{{ $item->city_id }}" @selected((string) request('destination') === (string) $item->city_id)>{{ $item->name }}</option>@endforeach</select></div>
            <div class="col-lg-2"><label class="form-label" for="date">Travel date</label><input id="date" type="date" class="form-control" name="date" value="{{ request('date') }}"></div>
            <div class="col-lg-2"><label class="form-label" for="min-price">Min price</label><input id="min-price" type="number" min="0" class="form-control" name="min_price" value="{{ request('min_price') }}"></div>
            <div class="col-lg-2"><label class="form-label" for="max-price">Max price</label><input id="max-price" type="number" min="0" class="form-control" name="max_price" value="{{ request('max_price') }}"></div>
            <div class="col-lg-3"><label class="form-label" for="duration">Duration</label><input id="duration" class="form-control" name="duration" value="{{ request('duration') }}" placeholder="e.g. 3 Days"></div>
            <div class="col-lg-9 d-flex align-items-end gap-2"><button class="theme-btn" type="submit"><span>Filter Tours</span></button><a class="theme-btn theme-btn-2" href="{{ route('tour.index') }}"><span>Clear</span></a></div>
        </form>

        <div class="row g-4">
            @forelse ($tours as $tour)
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="tour-box-items mt-0">
                        <div class="thumb"><a href="{{ route('tour.show', $tour) }}"><img src="{{ Storage::url($tour->thumbnail_image) }}" alt="{{ $tour->title }}"></a></div>
                        <div class="content">
                            <span>{{ $tour->city?->country?->name ?? $tour->city?->name }}</span>
                            <h4><a href="{{ route('tour.show', $tour) }}">{{ $tour->title }}</a></h4>
                            <h6>From <span>${{ number_format((float) $tour->price, 2) }}</span>@if($tour->old_price) <del>${{ number_format((float) $tour->old_price, 2) }}</del>@endif</h6>
                            <ul class="list"><li><i class="far fa-calendar"></i> {{ $tour->duration }}</li>@if($tour->countries_covered)<li><i class="far fa-flag"></i> {{ $tour->countries_covered }}</li>@endif</ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5"><h3>No tours found</h3><p>Try changing or clearing your filters.</p></div>
            @endforelse
        </div>
        <div class="mt-5">{{ $tours->links() }}</div>
    </div>
</section>
@endsection
