<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // currency
    public function currency()
    {
        return view('backend.settings.currency');
    }

    // language
    public function language()
    {
        return view('backend.settings.language');
    }
}
