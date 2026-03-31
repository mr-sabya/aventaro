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
}
