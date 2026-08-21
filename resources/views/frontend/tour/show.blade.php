@extends('frontend.layouts.app')

@section('content')
<div class="breadcrumb-wrapper section-padding bg-cover" style="background-image: url('{{ asset('assets/frontend/img/breadcrumb-bg.jpg') }}');">
    <div class="container-fluid"><div class="page-heading"><ul class="breadcrumb-items"><li><a href="{{ route('home') }}">Home</a></li><li><i class="far fa-slash"></i></li><li><a href="{{ route('tour.index') }}">Tours</a></li><li><i class="far fa-slash"></i></li><li>{{ $tour->title }}</li></ul><h1>{{ $tour->title }}</h1></div></div>
</div>

<section class="tour-details-section section-padding">
    <div class="container">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="row g-5">
            <div class="col-lg-8">
                <img class="img-fluid w-100 rounded mb-4" src="{{ Storage::url($tour->details_image) }}" alt="{{ $tour->title }}">
                <h2>{{ $tour->title }}</h2>
                <div class="d-flex flex-wrap gap-4 my-3">
                    <span><i class="far fa-map-marker-alt"></i> {{ $tour->city?->name }}@if($tour->city?->country), {{ $tour->city->country->name }}@endif</span>
                    <span><i class="far fa-calendar"></i> {{ $tour->duration }}</span>
                    @if($tour->address)<span><i class="far fa-location-arrow"></i> {{ $tour->address }}</span>@endif
                </div>
                <p>{!! nl2br(e($tour->description)) !!}</p>

                @if(!empty($tour->features))<h3 class="mt-5">Tour Features</h3><ul class="list-group list-group-flush mb-4">@foreach($tour->features as $feature)<li class="list-group-item"><i class="far fa-check text-success me-2"></i>{{ $feature }}</li>@endforeach</ul>@endif
                @if($tour->amenities->isNotEmpty())<h3 class="mt-5">Amenities</h3><div class="row g-3 mb-4">@foreach($tour->amenities as $amenity)<div class="col-md-4"><div class="border rounded p-3"><i class="{{ $amenity->icon_class }} me-2"></i>{{ $amenity->name }}</div></div>@endforeach</div>@endif
                @if($tour->plans->isNotEmpty())<h3 class="mt-5">Tour Plan</h3><div class="accordion mb-4" id="tour-plan">@foreach($tour->plans as $plan)<div class="accordion-item"><h4 class="accordion-header"><button class="accordion-button @if(!$loop->first) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#plan-{{ $plan->id }}">Day {{ $plan->day_number }}: {{ $plan->title }}</button></h4><div id="plan-{{ $plan->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" data-bs-parent="#tour-plan"><div class="accordion-body">{!! nl2br(e($plan->description)) !!}</div></div></div>@endforeach</div>@endif
                @if($tour->map_embed_url)<h3 class="mt-5">Location</h3><div class="ratio ratio-16x9 mb-4"><iframe src="{{ $tour->map_embed_url }}" title="Map for {{ $tour->title }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>@endif

                <h3 class="mt-5">Customer Reviews</h3>
                @forelse($tour->reviews as $review)<div class="border-bottom py-3"><div class="d-flex justify-content-between"><strong>{{ $review->name ?? $review->user?->name }}</strong><span class="text-warning">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5-$review->rating) }}</span></div>@if($review->location)<small>{{ $review->location }}</small>@endif<p class="mb-0 mt-2">{{ $review->comment }}</p></div>@empty<p>No approved reviews yet.</p>@endforelse

                <h3 class="mt-5">Add Your Review</h3>
                <form method="POST" action="{{ route('tour.reviews.store', $tour) }}" class="row g-3">@csrf
                    <div class="col-md-6"><label class="form-label">Name</label><input name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label class="form-label">Phone</label><input name="phone" value="{{ old('phone') }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Location</label><input name="location" value="{{ old('location') }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Rating</label><select name="rating" class="form-select" required>@for($rating=5;$rating>=1;$rating--)<option value="{{ $rating }}" @selected(old('rating')==$rating)>{{ $rating }} star{{ $rating>1?'s':'' }}</option>@endfor</select></div>
                    <div class="col-12"><label class="form-label">Comment</label><textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment') }}</textarea>@error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><button class="theme-btn" type="submit"><span>Submit Review</span></button></div>
                </form>
            </div>
            <aside class="col-lg-4"><div class="border rounded p-4 sticky-top" style="top: 30px">
                <h3>Book This Tour</h3><h2 class="text-primary my-3">{{ \App\Support\Money::format($tour->price) }} <small class="fs-6 text-muted">per traveller</small></h2>
                @if($tour->old_price)<p><del>{{ \App\Support\Money::format($tour->old_price) }}</del></p>@endif
                <p><strong>Duration:</strong> {{ $tour->duration }}</p>
                @if($tour->available_from)<p><strong>Available from:</strong> {{ $tour->available_from->format('M j, Y') }}</p>@endif
                @if($tour->available_to)<p><strong>Available to:</strong> {{ $tour->available_to->format('M j, Y') }}</p>@endif
                <p><strong>Capacity per date:</strong> {{ $tour->capacity_per_date }} travellers</p>
                <form method="POST" action="{{ route('booking.store', $tour) }}" class="row g-3 mt-2">@csrf
                    <div class="col-12"><label class="form-label">Travel date</label><input type="date" name="travel_date" min="{{ max(now()->format('Y-m-d'), $tour->available_from?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" @if($tour->available_to) max="{{ $tour->available_to->format('Y-m-d') }}" @endif value="{{ old('travel_date') }}" class="form-control @error('travel_date') is-invalid @enderror" required>@error('travel_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><label class="form-label">Travellers</label><input type="number" name="travellers" min="1" max="{{ min(50,$tour->capacity_per_date) }}" value="{{ old('travellers',1) }}" class="form-control @error('travellers') is-invalid @enderror" required>@error('travellers')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><label class="form-label">Name</label><input name="name" value="{{ old('name') }}" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Phone</label><input name="phone" value="{{ old('phone') }}" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
                    <div class="col-12"><label class="form-label">Coupon</label><input name="coupon_code" value="{{ old('coupon_code') }}" class="form-control @error('coupon_code') is-invalid @enderror" placeholder="Optional">@error('coupon_code')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><label class="form-label">Payment</label><select name="payment_method" class="form-select"><option value="pay_later">Pay later</option><option value="bank_transfer">Bank transfer</option></select></div>
                    <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea></div>
                    <div class="col-12"><button type="submit" class="theme-btn w-100"><span>Request Booking</span></button></div>
                </form>
            </div></aside>
        </div>

        @if($relatedTours->isNotEmpty())<div class="mt-5 pt-4"><h2>Related Tours</h2><div class="row g-4 mt-2">@foreach($relatedTours as $related)<div class="col-lg-3 col-md-6"><div class="tour-box-items mt-0"><div class="thumb"><img src="{{ Storage::url($related->thumbnail_image) }}" alt="{{ $related->title }}"></div><div class="content"><h4><a href="{{ route('tour.show',$related) }}">{{ $related->title }}</a></h4><h6>From <span>{{ \App\Support\Money::format($related->price) }}</span></h6></div></div></div>@endforeach</div></div>@endif
    </div>
</section>
@endsection
