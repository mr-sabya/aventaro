<?php

namespace App\Livewire\Frontend\Components;

use App\Models\DiscoverSection as DiscoverSectionModel;
use App\Models\Tour;
use Livewire\Component;

class DiscoverSection extends Component
{
    public function render()
    {
        return view('livewire.frontend.components.discover-section', [
            'section' => DiscoverSectionModel::query()->first(),
            'tours' => Tour::query()
                ->with('city.country')
                ->where('is_active', true)
                ->where('is_hot_deal', true)
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
