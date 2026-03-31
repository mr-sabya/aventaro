<?php

namespace App\Livewire\Backend\About;

use App\Models\AboutSection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    // Model Properties
    public $subtitle, $title, $description, $quote, $experience_years, $button_text, $button_url;
    public $main_image, $oldImage; // 'main_image' handles the upload, 'oldImage' handles the existing path
    public $features = [];

    public function mount()
    {
        $about = AboutSection::first();

        if ($about) {
            $this->subtitle = $about->subtitle;
            $this->title = $about->title;
            $this->description = $about->description;
            $this->quote = $about->quote;
            $this->experience_years = $about->experience_years;
            $this->button_text = $about->button_text;
            $this->button_url = $about->button_url;
            $this->features = $about->features ?? [];
            $this->oldImage = $about->main_image;
        }
    }

    public function addFeature()
    {
        $this->features[] = '';
    }
    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function save()
    {
        $validatedData = $this->validate([
            'subtitle' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quote' => 'nullable|string',
            'experience_years' => 'required|integer',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string',
            'main_image' => $this->oldImage ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $data = [
            'subtitle' => $this->subtitle,
            'title' => $this->title,
            'description' => $this->description,
            'quote' => $this->quote,
            'experience_years' => $this->experience_years,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'features' => array_filter($this->features),
        ];

        if ($this->main_image) {
            $data['main_image'] = $this->main_image->store('about', 'public');
            if ($this->oldImage) Storage::disk('public')->delete($this->oldImage);
            $this->oldImage = $data['main_image'];
        }

        AboutSection::updateOrCreate(['id' => 1], $data);

        $this->main_image = null;
        session()->flash('message', 'About Section updated successfully!');
    }

    public function render()
    {
        return view('livewire.backend.about.index');
    }
}
