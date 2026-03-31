<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    // index
    public function index()
    {
        return view('backend.destinations.index');
    }

    // faq
    public function faq()
    {
        return view('backend.destinations.faq');
    }

}
