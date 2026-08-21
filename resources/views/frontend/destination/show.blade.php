@extends('frontend.layouts.app')
@section('title',$destination->name.' | Aventaro')
@section('meta_description',Str::limit(strip_tags($destination->description ?: 'Explore '.$destination->name),155))
@section('canonical',route('destination.show',$destination))
@section('social_image',Storage::url($destination->image))
@push('structured-data')<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'TouristDestination','name'=>$destination->name,'description'=>strip_tags($destination->description),'image'=>Storage::url($destination->image),'url'=>route('destination.show',$destination),'containedInPlace'=>$destination->city?->country?->name?['@type'=>'Country','name'=>$destination->city->country->name]:null],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>@endpush

@section('content')
<div class="breadcrumb-wrapper section-padding bg-cover" style="background-image: url('{{ asset('assets/frontend/img/breadcrumb-bg.jpg') }}');"><div class="container-fluid"><div class="page-heading"><ul class="breadcrumb-items"><li><a href="{{ route('home') }}">Home</a></li><li><i class="far fa-slash"></i></li><li><a href="{{ route('destination.index') }}">Destinations</a></li><li><i class="far fa-slash"></i></li><li>{{ $destination->name }}</li></ul><h1>{{ $destination->name }}</h1></div></div></div>

<section class="section-padding"><div class="container">
    <div class="row g-5"><div class="col-lg-8">
        <img class="img-fluid w-100 rounded mb-4" src="{{ Storage::url($destination->image) }}" alt="{{ $destination->image_alt ?: $destination->name }}">
        <h2>About {{ $destination->name }}</h2><p>{!! nl2br(e($destination->description ?: 'Destination information will be available soon.')) !!}</p>
        @if(!empty($destination->features))<h3 class="mt-5">Experience the Difference</h3><ul class="list-group list-group-flush">@foreach($destination->features as $feature)<li class="list-group-item"><i class="far fa-check text-success me-2"></i>{{ $feature }}</li>@endforeach</ul>@endif
        @if($destination->map_embed_url)<h3 class="mt-5">Location</h3><div class="ratio ratio-16x9"><iframe src="{{ $destination->map_embed_url }}" title="Map of {{ $destination->name }}" loading="lazy"></iframe></div>@endif
        @if($destination->faqs->isNotEmpty())<h3 class="mt-5">Frequently Asked Questions</h3><div class="accordion" id="destination-faqs">@foreach($destination->faqs as $faq)<div class="accordion-item"><h4 class="accordion-header"><button class="accordion-button @unless($loop->first) collapsed @endunless" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}">{{ $faq->question }}</button></h4><div id="faq-{{ $faq->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" data-bs-parent="#destination-faqs"><div class="accordion-body">{{ $faq->answer }}</div></div></div>@endforeach</div>@endif
    </div><aside class="col-lg-4"><div class="border rounded p-4"><h3>Destination Details</h3><p><strong>City:</strong> {{ $destination->city?->name ?? '—' }}</p><p><strong>Country:</strong> {{ $destination->city?->country?->name ?? '—' }}</p><p><strong>Currency:</strong> {{ $destination->currency?->name ?? '—' }}</p><p><strong>Languages:</strong> {{ $destination->languages->pluck('name')->join(', ') ?: '—' }}</p><p><strong>Area:</strong> {{ $destination->area ?: '—' }}</p><p><strong>Visa requirements:</strong> {{ $destination->visa_requirements ?: 'Contact us for details' }}</p></div></aside></div>

    <div class="mt-5 pt-4"><h2>Tours in {{ $destination->name }}</h2><div class="row g-4 mt-2">@forelse($tours as $tour)<div class="col-xl-3 col-lg-4 col-md-6"><div class="tour-box-items mt-0"><div class="thumb"><img src="{{ Storage::url($tour->thumbnail_image) }}" alt="{{ $tour->title }}"></div><div class="content"><h4><a href="{{ route('tour.show',$tour) }}">{{ $tour->title }}</a></h4><h6>From <span>{{ \App\Support\Money::format($tour->price) }}</span></h6><ul class="list"><li><i class="far fa-calendar"></i>{{ $tour->duration }}</li></ul></div></div></div>@empty<div class="col-12"><p>No tours are currently listed for this destination.</p></div>@endforelse</div></div>
</div></section>
@endsection
