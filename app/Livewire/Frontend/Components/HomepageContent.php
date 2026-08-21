<?php

namespace App\Livewire\Frontend\Components;

use App\Models\AppPromotion;
use App\Models\BenefitItem;
use App\Models\NewsPost;
use App\Models\PromoBanner;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\TravelCategory;
use Livewire\Component;

class HomepageContent extends Component
{
    public function render()
    {
        return view('livewire.frontend.components.homepage-content', [
            'benefits'=>BenefitItem::where('is_active',true)->orderBy('sort_order')->get(),
            'team'=>TeamMember::where('is_active',true)->orderBy('sort_order')->limit(8)->get(),
            'categories'=>TravelCategory::where('is_active',true)->orderBy('sort_order')->limit(8)->get(),
            'promo'=>PromoBanner::where('is_active',true)->latest()->first(),
            'testimonials'=>Testimonial::where('is_active',true)->where('is_approved',true)->orderBy('sort_order')->get(),
            'articles'=>NewsPost::published()->latest('published_at')->limit(3)->get(),
            'appPromotion'=>AppPromotion::where('is_active',true)->latest()->first(),
        ]);
    }
}
