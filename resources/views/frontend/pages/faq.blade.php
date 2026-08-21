@extends('frontend.layouts.app')
@section('title',$page->meta_title ?: $page->title)
@section('meta_description',$page->meta_description)
@section('content')
@include('frontend.pages.partials.breadcrumb',['page'=>$page])
<section class="faq-section section-padding"><div class="container"><div class="section-title text-center"><span>Need Help?</span><h2>{{$page->title}}</h2><p class="mt-3">{{$page->content}}</p></div><div class="accordion mt-5 mx-auto" id="page-faq" style="max-width:900px">@forelse(data_get($page->sections,'faqs',[]) as $index=>$faq)<div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button {{$index?'collapsed':''}}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{$index}}">{{data_get($faq,'question')}}</button></h2><div id="faq-{{$index}}" class="accordion-collapse collapse {{$index===0?'show':''}}" data-bs-parent="#page-faq"><div class="accordion-body">{{data_get($faq,'answer')}}</div></div></div>@empty<p class="text-center">No frequently asked questions are published yet.</p>@endforelse</div></div></section>
@endsection
