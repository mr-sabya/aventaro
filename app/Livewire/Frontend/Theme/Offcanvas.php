<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\SiteSetting;
use Livewire\Component;

class Offcanvas extends Component
{
    public function render()
    {
        return view('livewire.frontend.theme.offcanvas', [
            'settings' => SiteSetting::query()->firstOrCreate([], ['site_name'=>'Aventaro']),
        ]);
    }
}
