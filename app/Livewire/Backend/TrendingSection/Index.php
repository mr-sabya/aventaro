<?php

namespace App\Livewire\Backend\TrendingSection;

use App\Models\TrendingDestinationSection;
use Livewire\Component;

class Index extends Component
{
    public $subtitle, $title, $button_text, $button_url;

    public function mount()
    {
        $section = TrendingDestinationSection::first();

        if ($section) {
            $this->subtitle = $section->subtitle;
            $this->title = $section->title;
            $this->button_text = $section->button_text;
            $this->button_url = $section->button_url;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'subtitle' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'button_url' => 'required|string|max:255',
        ]);

        TrendingDestinationSection::updateOrCreate(
            ['id' => 1],
            $validatedData
        );

        session()->flash('message', 'Trending Destination Section updated successfully!');
    }

    public function render()
    {
        return view('livewire.backend.trending-section.index');
    }
}