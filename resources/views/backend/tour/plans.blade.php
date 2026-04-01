@extends('backend.layouts.app')

@section('content')
<livewire:backend.tour.plan-manager tourId="{{ $plan->id }}" />
@endsection