<?php

namespace App\Livewire\Frontend\Components;

use App\Models\BrandSection as BrandSectionModel;
use App\Models\Partner;
use Livewire\Component;

class BrandSection extends Component
{
    public function render()
    {
        return view('livewire.frontend.components.brand-section', [
            'section' => BrandSectionModel::query()->first(),
            'partners' => Partner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
