<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\SiteSetting;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        return view('livewire.frontend.theme.header', [
            'settings' => SiteSetting::query()->firstOrCreate([], ['site_name' => 'Aventaro']),
        ]);
    }
}
