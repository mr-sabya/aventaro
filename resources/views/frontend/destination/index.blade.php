@extends('frontend.layouts.app')
@section('title','Destinations | Aventaro')
@section('meta_description','Explore inspiring destinations and find available Aventaro tours.')

@section('content')
<div class="breadcrumb-wrapper section-padding bg-cover" style="background-image: url('{{ asset('assets/frontend/img/breadcrumb-bg.jpg') }}');">
    <div class="container-fluid"><div class="page-heading">
        <ul class="breadcrumb-items"><li><a href="{{ route('home') }}">Home</a></li><li><i class="far fa-slash"></i></li><li>Destinations</li></ul>
        <h1>Our Destinations</h1>
    </div></div>
</div>

<div class="trending-destinations section-padding">
    <div class="container">
        <form method="GET" action="{{ route('destination.index') }}" class="row justify-content-center mb-5">
            <div class="col-lg-7"><div class="input-group"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search destination, city, or country"><button class="theme-btn" type="submit"><span>Search</span></button></div></div>
        </form>
        <div class="row g-4">
            @forelse ($destinations as $destination)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="trending-destinations-card-items mt-0"><div class="destinations-img">
                        <img src="{{ Storage::url($destination->image) }}" alt="{{ $destination->name }}">
                        <ul class="destinations-content"><li class="title"><a href="{{ route('destination.show', $destination) }}">{{ $destination->name }}@if($destination->city?->country), {{ $destination->city->country->name }}@endif</a></li></ul>
                        <div class="icon"><a href="{{ route('destination.show', $destination) }}" aria-label="View {{ $destination->name }}"><i class="fas fa-arrow-right"></i></a></div>
                    </div></div>
                </div>
            @empty
                <div class="col-12 text-center py-5"><h3>No destinations found</h3><p>Try another search.</p></div>
            @endforelse
        </div>
        <div class="mt-5">{{ $destinations->links() }}</div>
    </div>
</div>
@endsection
