@extends('frontend.layouts.app')
@section('title','Page Not Found')
@section('content')
<section class="error-section section-padding"><div class="container text-center py-5"><img src="{{asset('assets/frontend/img/404.png')}}" class="img-fluid mb-4" alt="404" onerror="this.style.display='none'"><h1>Page not found</h1><p class="mt-3">The page you requested may have moved or no longer exists.</p><a href="{{route('home')}}" class="theme-btn mt-4"><span>Back to home</span></a></div></section>
@endsection
