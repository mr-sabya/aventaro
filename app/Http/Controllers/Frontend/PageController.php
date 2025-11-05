<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // 
    public function aboutPage()
    {
        return view('frontend.about.index');    
    }

    // contact page
    public function contactPage()
    {
        return view('frontend.contact.index');    
    }
}
