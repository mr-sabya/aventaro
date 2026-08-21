<?php

namespace App\Livewire\Frontend\Components;

use App\Models\HeroSlide;
use Livewire\Component;

class HeroSlider extends Component
{
    public function render()
    {
        return view('livewire.frontend.components.hero-slider', [
            'slides' => HeroSlide::query()
                ->where('is_active', true)
                ->orderBy('order')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
