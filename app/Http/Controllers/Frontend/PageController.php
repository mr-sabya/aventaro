<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\Destination;
use App\Models\NewsPost;
use App\Models\TeamMember;

class PageController extends Controller
{
    // 
    public function aboutPage()
    {
        $page = ContentPage::where('slug','about-us')->where('is_active',true)->firstOrFail();
        return view('frontend.about.index', [
            'page'=>$page,
            'destinations'=>Destination::query()->where('is_active',true)->orderByDesc('is_trending')->limit(8)->get(),
            'members'=>TeamMember::query()->where('is_active',true)->orderBy('sort_order')->limit(4)->get(),
            'posts'=>NewsPost::published()->latest('published_at')->limit(3)->get(),
        ]);
    }

    public function faq()
    {
        return view('frontend.pages.faq', ['page'=>ContentPage::where('slug','faq')->where('is_active',true)->firstOrFail()]);
    }

    public function show(string $slug)
    {
        return view('frontend.pages.show', ['page'=>ContentPage::where('slug',$slug)->where('is_active',true)->firstOrFail()]);
    }

    // contact page
    public function contactPage()
    {
        return view('frontend.contact.index');    
    }
}
