<?php

namespace App\Livewire\Backend\FeatureSection;

use App\Models\FeaturedTourSection;
use Livewire\Component;

class Index extends Component
{
    // Model Properties
    public $subtitle, $title, $description;

    /**
     * Initialize the component with existing data
     */
    public function mount()
    {
        $section = FeaturedTourSection::first();

        if ($section) {
            $this->subtitle = $section->subtitle;
            $this->title = $section->title;
            $this->description = $section->description;
        }
    }

    /**
     * Save or Update the single record
     */
    public function save()
    {
        $validatedData = $this->validate([
            'subtitle' => 'required|string|max:255',
            'title'    => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        FeaturedTourSection::updateOrCreate(
            ['id' => 1],
            $validatedData
        );

        session()->flash('message', 'Featured Section content updated successfully!');
    }

    public function render()
    {
        return view('livewire.backend.feature-section.index');
    }
}
