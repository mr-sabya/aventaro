<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tour;

class TourController extends Controller
{
    // amenity manager
    public function amenities()
    {
        return view('backend.tour.amenities');
    }

    // index
    public function index()
    {
        return view('backend.tour.index');
    }

    public function reviews()
    {
        return view('backend.tour.reviews');
    }

    // plan manager
    public function plans($id)
    {
        $plan = Tour::findOrFail($id);
        return view('backend.tour.plans', compact('plan'));
    }

}
