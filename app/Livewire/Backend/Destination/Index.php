<?php

namespace App\Livewire\Backend\Destination;

use App\Models\Destination;
use App\Models\City;
use App\Models\Country; // Added
use App\Models\Currency;
use App\Models\Language;
use App\Models\DestinationFaq;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Model Properties
    public $destinationId, $city_id, $currency_id, $name, $description, $visa_requirements, $area, $map_embed_url;
    public $selected_country_id; // Added for dependent dropdown
    public $image, $oldImage;
    public $is_trending = false;
    public $is_active = true;
    public $features = [];
    public $selectedLanguages = [];
    public $selectedFaqs = [];

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
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

    // Reset city when country changes
    public function updatedSelectedCountryId($value)
    {
        $this->city_id = null;
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

    public function resetFields()
    {
        $this->reset([
            'destinationId',
            'selected_country_id',
            'city_id',
            'currency_id',
            'name',
            'description',
            'visa_requirements',
            'area',
            'map_embed_url',
            'image',
            'oldImage',
            'is_trending',
            'is_active',
            'features',
            'selectedLanguages',
            'selectedFaqs',
            'isEditMode'
        ]);
        $this->features = [];
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->isEditMode = true;
        // Eager load city and its country
        $destination = Destination::with(['languages', 'faqs', 'city.country'])->findOrFail($id);

        $this->destinationId = $id;
        $this->selected_country_id = $destination->city->country_id; // Set country from existing city
        $this->city_id = $destination->city_id;
        $this->currency_id = $destination->currency_id;
        $this->name = $destination->name;
        $this->description = $destination->description;
        $this->visa_requirements = $destination->visa_requirements;
        $this->area = $destination->area;
        $this->map_embed_url = $destination->map_embed_url;
        $this->is_trending = $destination->is_trending;
        $this->is_active = $destination->is_active;
        $this->features = $destination->features ?? [];
        $this->oldImage = $destination->image;

        $this->selectedLanguages = $destination->languages->pluck('id')->toArray();
        $this->selectedFaqs = $destination->faqs->pluck('id')->toArray();

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'selected_country_id' => 'required',
            'city_id' => 'required|exists:cities,id',
            'currency_id' => 'required|exists:currencies,id',
            'image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];

        $this->validate($rules);

        $data = [
            'city_id' => $this->city_id,
            'currency_id' => $this->currency_id,
            'name' => $this->name,
            'description' => $this->description,
            'visa_requirements' => $this->visa_requirements,
            'area' => $this->area,
            'map_embed_url' => $this->map_embed_url,
            'is_trending' => $this->is_trending,
            'is_active' => $this->is_active,
            'features' => array_filter($this->features),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('destinations', 'public');
            if ($this->oldImage) Storage::disk('public')->delete($this->oldImage);
        }

        $destination = Destination::updateOrCreate(['id' => $this->destinationId], $data);

        if ($this->isEditMode) {
            $destination->slug = Str::slug($this->name);
            $destination->save();
        }

        $destination->languages()->sync($this->selectedLanguages);
        $destination->faqs()->sync($this->selectedFaqs);

        session()->flash('message', 'Destination Saved Successfully.');
        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function render()
    {
        // Filter cities based on selected country
        $availableCities = collect();
        if (!empty($this->selected_country_id)) {
            $availableCities = City::where('country_id', $this->selected_country_id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        return view('livewire.backend.destination.index', [
            'destinations' => Destination::with(['city.country', 'currency'])
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'countries' => Country::where('is_active', true)->orderBy('name')->get(),
            'cities' => $availableCities,
            'currencies' => Currency::orderBy('name')->get(),
            'languages' => Language::orderBy('name')->get(),
            'allFaqs' => DestinationFaq::where('is_active', true)->get()
        ]);
    }
}
