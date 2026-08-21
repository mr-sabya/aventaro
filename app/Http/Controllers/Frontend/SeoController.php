<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\Destination;
use App\Models\NewsPost;
use App\Models\Tour;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls=collect([
            ['loc'=>route('home'),'lastmod'=>now()],['loc'=>route('tour.index'),'lastmod'=>now()],['loc'=>route('destination.index'),'lastmod'=>now()],['loc'=>route('news.index'),'lastmod'=>now()],
        ]);
        ContentPage::where('is_active',true)->get()->each(function($page)use($urls){$route=match($page->slug){'about-us'=>'pages.about','faq'=>'pages.faq','privacy-policy'=>'pages.privacy','terms'=>'pages.terms',default=>null};if($route)$urls->push(['loc'=>route($route),'lastmod'=>$page->updated_at]);});
        Tour::where('is_active',true)->get()->each(fn($item)=>$urls->push(['loc'=>route('tour.show',$item),'lastmod'=>$item->updated_at]));
        Destination::where('is_active',true)->get()->each(fn($item)=>$urls->push(['loc'=>route('destination.show',$item),'lastmod'=>$item->updated_at]));
        NewsPost::published()->get()->each(fn($item)=>$urls->push(['loc'=>route('news.show',$item),'lastmod'=>$item->updated_at]));
        return response()->view('frontend.seo.sitemap',compact('urls'))->header('Content-Type','application/xml');
    }
    public function robots(): Response
    {
        $body="User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /bookings/\nSitemap: ".route('sitemap')."\n";
        return response($body)->header('Content-Type','text/plain');
    }
}
