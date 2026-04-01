<?php

namespace App\Livewire\Backend\BrandSection;

use App\Models\BrandSection;
use Livewire\Component;

class Index extends Component
{
    // Model Properties
    public $text;

    public function mount()
    {
        // Fetch the first record or initialize empty
        $brand = BrandSection::first();

        if ($brand) {
            $this->text = $brand->text;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'text' => 'required|string|max:500',
        ]);

        // Always update the first record or create it
        BrandSection::updateOrCreate(
            ['id' => 1], 
            ['text' => $this->text]
        );

        session()->flash('message', 'Brand Section updated successfully!');
    }

    public function render()
    {
        return view('livewire.backend.brand-section.index');
    }
}