<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    //
    public function heroSlider()
    {
        return view('backend.slider.index');
    }

    // about section
    public function aboutSection()
    {
        return view('backend.about-section.index');
    }

    // partner
    public function partner()
    {
        return view('backend.partner.index');
    }

    // brand section
    public function brandSection()
    {
        return view('backend.brand-section.index');
    }

    // trending destination section
    public function trendingDestinationSection()
    {
        return view('backend.trending-section.index');
    }

    // feature-section
    public function featureSection()
    {
        return view('backend.feature-section.index');
    }

    // discover-section
    public function discoverSection()
    {
        return view('backend.discover-section.index');
    }
}
