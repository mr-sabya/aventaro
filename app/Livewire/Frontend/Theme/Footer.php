<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\FooterGallery;
use App\Models\FooterLink;
use App\Models\SiteSetting;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        return view('livewire.frontend.theme.footer', [
            'settings' => SiteSetting::query()->firstOrCreate([], ['site_name' => 'Aventaro']),
            'linkGroups' => FooterLink::query()->where('is_active', true)->orderBy('sort_order')->get()->groupBy('group_name'),
            'gallery' => FooterGallery::query()->where('is_active', true)->orderBy('sort_order')->limit(9)->get(),
        ]);
    }
}
