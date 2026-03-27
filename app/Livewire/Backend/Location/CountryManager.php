<?php

namespace App\Livewire\Backend\Location;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CountryManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Model Properties
    public $name, $countryId;
    public $is_active = true;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // UI State
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:countries,name',
        'is_active' => 'boolean',
    ];

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
        $this->reset(['name', 'is_active', 'countryId', 'isEditMode']);
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $country = Country::findOrFail($id);
        $this->countryId = $id;
        $this->name = $country->name;
        $this->is_active = $country->is_active;
        
        $this->dispatch('show-modal');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $this->countryId,
            'is_active' => 'boolean',
        ]);

        $country = Country::updateOrCreate(
            ['id' => $this->countryId],
            [
                'name' => $this->name,
                'is_active' => $this->is_active,
                // Slug is handled by the Model's boot method
            ]
        );

        // Update slug manually if editing (since boot method only handles creating)
        if($this->isEditMode) {
            $country->slug = Str::slug($this->name);
            $country->save();
        }

        session()->flash('message', $this->isEditMode ? 'Country Updated.' : 'Country Created.');
        
        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function toggleStatus($id)
    {
        $country = Country::findOrFail($id);
        $country->is_active = !$country->is_active;
        $country->save();
    }

    public function delete($id)
    {
        Country::find($id)->delete();
        session()->flash('message', 'Country Deleted.');
    }

    public function render()
    {
        $countries = Country::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.location.country-manager', ['countries' => $countries]);
    }

}
