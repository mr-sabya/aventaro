<?php

namespace App\Livewire\Backend\Location;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CityManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Model Properties
    public $name, $country_id, $cityId;
    public $is_active = true;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
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
        $this->reset(['name', 'country_id', 'is_active', 'cityId', 'isEditMode']);
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $city = City::findOrFail($id);
        $this->cityId = $id;
        $this->name = $city->name;
        $this->country_id = $city->country_id;
        $this->is_active = $city->is_active;

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255|unique:cities,name,' . $this->cityId,
            'is_active' => 'boolean',
        ]);

        $city = City::updateOrCreate(
            ['id' => $this->cityId],
            [
                'country_id' => $this->country_id,
                'name' => $this->name,
                'is_active' => $this->is_active,
            ]
        );

        // Manually update slug on edit because boot method only fires on 'creating'
        if ($this->isEditMode) {
            $city->slug = Str::slug($this->name);
            $city->save();
        }

        session()->flash('message', $this->isEditMode ? 'City updated successfully.' : 'City created successfully.');

        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function toggleStatus($id)
    {
        $city = City::findOrFail($id);
        $city->is_active = !$city->is_active;
        $city->save();
    }

    public function delete($id)
    {
        City::find($id)->delete();
        session()->flash('message', 'City deleted successfully.');
    }

    public function render()
    {
        $cities = City::with('country') // Eager load country to optimize queries
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('country', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $countries = Country::orderBy('name')->get();

        return view('livewire.backend.location.city-manager', [
            'cities' => $cities,
            'countries' => $countries
        ]);
    }
}
