<?php

namespace App\Livewire\Frontend\Components;

use App\Models\AboutSection as AboutSectionModel;
use Livewire\Component;

class AboutSection extends Component
{
    public function render()
    {
        return view('livewire.frontend.components.about-section', [
            'about' => AboutSectionModel::query()->first(),
        ]);
    }
}
