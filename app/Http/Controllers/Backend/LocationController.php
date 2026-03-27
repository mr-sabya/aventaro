<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // country
    public function country()
    {
        return view('backend.location.country');
    }
    // city
    public function city()
    {
        return view('backend.location.city');
    }
}
