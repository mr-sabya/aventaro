<?php

namespace App\Livewire\Backend\Slider;

use App\Models\HeroSlide;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Model Properties
    public $subtitle, $title_part_1, $title_part_2, $title_part_3, $description, $background_image, $order;
    public $is_active = true;
    public $slideId, $oldImage;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'order';
    public $sortDirection = 'asc';

    // UI State
    public $isEditMode = false;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFields()
    {
        $this->reset(['subtitle', 'title_part_1', 'title_part_2', 'title_part_3', 'description', 'background_image', 'is_active', 'order', 'slideId', 'oldImage', 'isEditMode']);
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $slide = HeroSlide::findOrFail($id);
        $this->slideId = $id;
        $this->subtitle = $slide->subtitle;
        $this->title_part_1 = $slide->title_part_1;
        $this->title_part_2 = $slide->title_part_2;
        $this->title_part_3 = $slide->title_part_3;
        $this->description = $slide->description;
        $this->order = $slide->order;
        $this->is_active = $slide->is_active;
        $this->oldImage = $slide->background_image;

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $rules = [
            'subtitle' => 'required|string|max:255',
            'title_part_1' => 'required|string|max:255',
            'title_part_2' => 'required|string|max:255',
            'title_part_3' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'background_image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];

        $validatedData = $this->validate($rules);

        if ($this->background_image) {
            $validatedData['background_image'] = $this->background_image->store('hero-slides', 'public');
            if ($this->oldImage) Storage::disk('public')->delete($this->oldImage);
        }

        HeroSlide::updateOrCreate(['id' => $this->slideId], $validatedData + [
            'title_part_2' => $this->title_part_2,
            'title_part_3' => $this->title_part_3,
        ]);

        session()->flash('message', $this->isEditMode ? 'Slide Updated Successfully.' : 'Slide Created Successfully.');

        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function delete($id)
    {
        $slide = HeroSlide::find($id);
        if ($slide->background_image) Storage::disk('public')->delete($slide->background_image);
        $slide->delete();
        session()->flash('message', 'Slide Deleted Successfully.');
    }

    public function render()
    {
        $slides = HeroSlide::query()
            ->where('title_part_1', 'like', '%' . $this->search . '%')
            ->orWhere('subtitle', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.slider.index', ['slides' => $slides]);
    }
}
