<?php

namespace App\Livewire\Frontend\Components;

use App\Models\FeaturedTourSection;
use App\Models\Tour;
use Livewire\Component;

class TourSection extends Component
{
    public function render()
    {
        return view('livewire.frontend.components.tour-section', [
            'section' => FeaturedTourSection::query()->first(),
            'tours' => Tour::query()
                ->with('city.country')
                ->where('is_active', true)
                ->where('is_featured', true)
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
