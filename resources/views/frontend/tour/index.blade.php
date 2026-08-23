@extends('frontend.layouts.app')
@section('title','Tour Packages | Aventaro')
@section('meta_description','Browse and book curated tour packages for your next adventure.')

@section('content')
<div class="breadcrumb-wrapper section-padding bg-cover" style="background-image: url('{{ asset('assets/frontend/img/breadcrumb-bg.jpg') }}');">
    <div class="container-fluid"><div class="page-heading">
        <ul class="breadcrumb-items"><li><a href="{{ route('home') }}">Home</a></li><li><i class="far fa-slash"></i></li><li>Tour Packages</li></ul>
        <h1>Tour Packages</h1>
    </div></div>
</div>

<section class="tour-section fix section-padding">
    <div class="container">
        <livewire:frontend.tour-catalog />
    </div>
</section>
@endsection
