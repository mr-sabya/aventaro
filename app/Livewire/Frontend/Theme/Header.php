<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Currency;
use App\Models\Language;
use App\Models\SiteSetting;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        return view('livewire.frontend.theme.header', [
            'settings' => SiteSetting::query()->firstOrCreate([], ['site_name' => 'Aventaro']),
            'currencies' => Currency::query()->where('is_active', true)->orderBy('code')->get(),
            'languages' => Language::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
