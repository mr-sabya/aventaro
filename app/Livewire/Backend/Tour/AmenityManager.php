<?php

namespace App\Livewire\Backend\Tour;

use App\Models\Amenity;
use Livewire\Component;
use Livewire\WithPagination;

class AmenityManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $icon_class, $amenityId;
    public $search = '', $perPage = 10, $isEditMode = false;

    public function resetFields() {
        $this->reset(['name', 'icon_class', 'amenityId', 'isEditMode']);
        $this->resetValidation();
    }

    public function edit($id) {
        $this->isEditMode = true;
        $amenity = Amenity::findOrFail($id);
        $this->amenityId = $id;
        $this->name = $amenity->name;
        $this->icon_class = $amenity->icon_class;
        $this->dispatch('show-modal');
    }

    public function save() {
        $this->validate([
            'name' => 'required|string|max:255',
            'icon_class' => 'required|string|max:255',
        ]);

        Amenity::updateOrCreate(['id' => $this->amenityId], [
            'name' => $this->name,
            'icon_class' => $this->icon_class,
        ]);

        session()->flash('message', 'Amenity Saved.');
        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function delete($id) {
        Amenity::find($id)->delete();
    }

    public function render() {
        return view('livewire.backend.tour.amenity-manager', [
            'amenities' => Amenity::where('name', 'like', '%'.$this->search.'%')->paginate($this->perPage)
        ]);
    }
}