<?php

namespace App\Livewire\Backend\DiscoverSection;

use App\Models\DiscoverSection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    // Model Properties
    public $subtitle, $title, $description, $button_text, $button_url;
    public $background_image, $oldImage;

    /**
     * Initialize with existing data
     */
    public function mount()
    {
        $section = DiscoverSection::first();

        if ($section) {
            $this->subtitle = $section->subtitle;
            $this->title = $section->title;
            $this->description = $section->description;
            $this->button_text = $section->button_text;
            $this->button_url = $section->button_url;
            $this->oldImage = $section->background_image;
        }
    }

    /**
     * Save or Update the record
     */
    public function save()
    {
        $validatedData = $this->validate([
            'subtitle' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string',
            'background_image' => $this->oldImage ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $data = [
            'subtitle' => $this->subtitle,
            'title' => $this->title,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
        ];

        // Handle Image Upload
        if ($this->background_image) {
            $data['background_image'] = $this->background_image->store('sections', 'public');
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $this->oldImage = $data['background_image'];
        }

        DiscoverSection::updateOrCreate(['id' => 1], $data);

        $this->background_image = null; // Clear the temporary upload
        session()->flash('message', 'Discover Section updated successfully!');
    }

    public function render()
    {
        return view('livewire.backend.discover-section.index');
    }
}
