@extends('frontend.layouts.app')

@section('content')
<div class="breadcrumb-wrapper section-padding bg-cover" style="background-image:url('{{ asset('assets/frontend/img/breadcrumb-bg.jpg') }}')"><div class="container-fluid"><div class="page-heading"><h1>Booking {{ $booking->reference }}</h1></div></div></div>
<section class="section-padding"><div class="container"><div class="row justify-content-center"><div class="col-lg-8">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->has('booking'))<div class="alert alert-danger">{{ $errors->first('booking') }}</div>@endif
    <div class="card shadow-sm"><div class="card-body p-4 p-md-5"><div class="d-flex justify-content-between align-items-start flex-wrap gap-3"><div><p class="text-muted mb-1">Booking reference</p><h2>{{ $booking->reference }}</h2></div><span class="badge fs-6 {{ in_array($booking->status,['cancelled','refunded']) ? 'bg-danger' : ($booking->status==='confirmed'?'bg-success':'bg-warning') }}">{{ ucfirst($booking->status) }}</span></div><hr>
        <h3>{{ $booking->tour->title }}</h3><p>{{ $booking->tour->city?->name }}@if($booking->tour->city?->country), {{ $booking->tour->city->country->name }}@endif</p>
        <div class="row g-3"><div class="col-md-6"><strong>Travel date</strong><br>{{ $booking->travel_date->format('F j, Y') }}</div><div class="col-md-6"><strong>Travellers</strong><br>{{ $booking->travellers }}</div><div class="col-md-6"><strong>Guest</strong><br>{{ $booking->name }}<br>{{ $booking->email }}<br>{{ $booking->phone }}</div><div class="col-md-6"><strong>Payment</strong><br>{{ str($booking->payment_method)->replace('_',' ')->title() }} — {{ ucfirst($booking->payment_status) }}</div></div>
        <hr><div class="d-flex justify-content-between"><span>Subtotal</span><strong>${{ number_format((float)$booking->subtotal,2) }}</strong></div>@if($booking->discount>0)<div class="d-flex justify-content-between text-success"><span>Discount @if($booking->coupon_code)({{ $booking->coupon_code }})@endif</span><strong>-${{ number_format((float)$booking->discount,2) }}</strong></div>@endif<div class="d-flex justify-content-between fs-4 mt-2"><span>Total</span><strong>${{ number_format((float)$booking->total,2) }}</strong></div>
        @if(in_array($booking->status,['pending','confirmed']))<hr><form method="POST" action="{{ route('booking.cancel',$booking) }}" onsubmit="return confirm('Cancel this booking?')">@csrf<input type="hidden" name="token" value="{{ $booking->cancellation_token }}"><button class="btn btn-outline-danger" type="submit">Cancel Booking</button></form>@endif
    </div></div>
</div></div></div></section>
@endsection
