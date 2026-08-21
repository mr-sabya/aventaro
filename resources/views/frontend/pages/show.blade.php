@extends('frontend.layouts.app')
@section('title',$page->meta_title ?: $page->title)
@section('meta_description',$page->meta_description)
@section('content')
@include('frontend.pages.partials.breadcrumb',['page'=>$page])
<section class="section-padding"><div class="container"><article class="mx-auto" style="max-width:900px"><h2>{{$page->title}}</h2><div class="mt-4 lh-lg">{!! nl2br(e($page->content)) !!}</div></article></div></section>
@endsection
