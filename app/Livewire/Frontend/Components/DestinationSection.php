<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Destination;
use App\Models\TrendingDestinationSection;
use Livewire\Component;

class DestinationSection extends Component
{
    public function render()
    {
        return view('livewire.frontend.components.destination-section', [
            'section' => TrendingDestinationSection::query()->first(),
            'destinations' => Destination::query()
                ->with('city.country')
                ->where('is_active', true)
                ->where('is_trending', true)
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
