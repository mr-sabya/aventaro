<?php

namespace App\Livewire\Backend\Tour;

use App\Models\Tour;
use App\Models\Country;
use App\Models\City;
use App\Models\Amenity;
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
    public $tourId, $city_id, $selected_country_id, $title, $address, $description, $price, $old_price, $duration, $available_from, $available_to, $capacity_per_date = 20, $countries_covered, $map_embed_url, $image_alt;
    public $thumbnail_image, $details_image, $old_thumbnail, $old_details;
    public $is_featured = false, $is_hot_deal = false, $is_active = true;
    public $features = [];
    public $selectedAmenities = [];

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
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

    // Dependent Dropdown Logic
    public function updatedSelectedCountryId($value)
    {
        $this->city_id = null;
    }

    // Dynamic Features Logic
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
            'tourId',
            'city_id',
            'selected_country_id',
            'title',
            'address',
            'description',
            'price',
            'old_price',
            'duration',
            'available_from',
            'available_to',
            'capacity_per_date',
            'countries_covered',
            'map_embed_url',
            'thumbnail_image',
            'details_image',
            'old_thumbnail',
            'old_details',
            'is_featured',
            'is_hot_deal',
            'is_active',
            'features',
            'selectedAmenities',
            'isEditMode'
        ]);
        $this->features = [];
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->isEditMode = true;
        $tour = Tour::with(['amenities', 'city.country'])->findOrFail($id);

        $this->tourId = $id;
        $this->selected_country_id = $tour->city->country_id;
        $this->city_id = $tour->city_id;
        $this->title = $tour->title;
        $this->address = $tour->address;
        $this->description = $tour->description;
        $this->price = $tour->price;
        $this->old_price = $tour->old_price;
        $this->duration = $tour->duration;
        $this->available_from = $tour->available_from?->format('Y-m-d');
        $this->available_to = $tour->available_to?->format('Y-m-d');
        $this->capacity_per_date = $tour->capacity_per_date;
        $this->countries_covered = $tour->countries_covered;
        $this->map_embed_url = $tour->map_embed_url;
        $this->is_featured = $tour->is_featured;
        $this->is_hot_deal = $tour->is_hot_deal;
        $this->is_active = $tour->is_active;
        $this->features = $tour->features ?? [];
        $this->old_thumbnail = $tour->thumbnail_image;
        $this->old_details = $tour->details_image;
        $this->image_alt = $tour->image_alt;
        $this->selectedAmenities = $tour->amenities->pluck('id')->toArray();

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'duration' => 'required|string',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after_or_equal:available_from',
            'capacity_per_date' => 'required|integer|min:1|max:10000',
            'thumbnail_image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'details_image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'image_alt' => 'nullable|string|max:255',
        ];

        $this->validate($rules);

        $data = [
            'city_id' => $this->city_id,
            'title' => $this->title,
            'address' => $this->address,
            'description' => $this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'duration' => $this->duration,
            'available_from' => $this->available_from,
            'available_to' => $this->available_to,
            'capacity_per_date' => $this->capacity_per_date,
            'countries_covered' => $this->countries_covered,
            'map_embed_url' => $this->map_embed_url,
            'image_alt' => $this->image_alt,
            'is_featured' => $this->is_featured,
            'is_hot_deal' => $this->is_hot_deal,
            'is_active' => $this->is_active,
            'features' => array_filter($this->features),
        ];

        // Handle Images
        if ($this->thumbnail_image) {
            $data['thumbnail_image'] = $this->thumbnail_image->store('tours/thumbnails', 'public');
            if ($this->old_thumbnail) Storage::disk('public')->delete($this->old_thumbnail);
        }
        if ($this->details_image) {
            $data['details_image'] = $this->details_image->store('tours/details', 'public');
            if ($this->old_details) Storage::disk('public')->delete($this->old_details);
        }

        $tour = Tour::updateOrCreate(['id' => $this->tourId], $data);

        if ($this->isEditMode) {
            $tour->slug = Str::slug($this->title);
            $tour->save();
        }

        $tour->amenities()->sync($this->selectedAmenities);

        session()->flash('message', 'Tour saved successfully.');
        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function delete($id)
    {
        $tour = Tour::findOrFail($id);
        if ($tour->thumbnail_image) Storage::disk('public')->delete($tour->thumbnail_image);
        if ($tour->details_image) Storage::disk('public')->delete($tour->details_image);
        $tour->delete();
        session()->flash('message', 'Tour Deleted.');
    }

    public function render()
    {
        $availableCities = $this->selected_country_id
            ? City::where('country_id', $this->selected_country_id)->orderBy('name')->get()
            : collect();

        $tours = Tour::with(['city.country'])
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.tour.index', [
            'tours' => $tours,
            'countries' => Country::orderBy('name')->get(),
            'cities' => $availableCities,
            'allAmenities' => Amenity::orderBy('name')->get()
        ]);
    }
}
