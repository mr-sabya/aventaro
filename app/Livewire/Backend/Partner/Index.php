<?php

namespace App\Livewire\Backend\Partner;

use App\Models\Partner;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Model Properties
    public $partnerId, $name, $url, $sort_order, $image, $oldImage;
    public $is_active = true;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
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
        $this->reset(['partnerId', 'name', 'url', 'sort_order', 'image', 'oldImage', 'is_active', 'isEditMode']);
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $partner = Partner::findOrFail($id);
        $this->partnerId = $id;
        $this->name = $partner->name;
        $this->url = $partner->url;
        $this->sort_order = $partner->sort_order;
        $this->is_active = $partner->is_active;
        $this->oldImage = $partner->image;

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'url' => 'nullable|url',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
            'image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];

        $validatedData = $this->validate($rules);

        if ($this->image) {
            $validatedData['image'] = $this->image->store('partners', 'public');
            if ($this->oldImage) Storage::disk('public')->delete($this->oldImage);
        }

        Partner::updateOrCreate(['id' => $this->partnerId], $validatedData);

        session()->flash('message', $this->isEditMode ? 'Partner Updated Successfully.' : 'Partner Created Successfully.');

        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function delete($id)
    {
        $partner = Partner::find($id);
        if ($partner->image) Storage::disk('public')->delete($partner->image);
        $partner->delete();
        session()->flash('message', 'Partner Deleted Successfully.');
    }

    public function render()
    {
        $partners = Partner::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.partner.index', ['partners' => $partners]);
    }
}
