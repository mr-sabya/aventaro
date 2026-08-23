<?php

namespace App\Livewire\Frontend;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TourCatalog extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $destination = '';

    #[Url(except: '')]
    public string $date = '';

    #[Url(as: 'min_price', except: '')]
    public string $minPrice = '';

    #[Url(as: 'max_price', except: '')]
    public string $maxPrice = '';

    #[Url(except: '')]
    public string $duration = '';

    #[Url(except: '')]
    public string $activity = '';

    #[Url(except: '')]
    public string $guests = '';

    public function updated($property): void
    {
        if (in_array($property, ['search', 'destination', 'date', 'minPrice', 'maxPrice', 'duration', 'activity', 'guests'], true)) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'destination', 'date', 'minPrice', 'maxPrice', 'duration', 'activity', 'guests']);
        $this->resetPage();
    }

    public function render(): View
    {
        $tours = Tour::query()
            ->with('city.country')
            ->where('is_active', true)
            ->when($this->search !== '', fn ($query) => $query->where(fn ($q) => $q
                ->where('title', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%")
                ->orWhere('address', 'like', "%{$this->search}%")))
            ->when($this->destination !== '', fn ($query) => $query->whereHas('city', fn ($q) => $q
                ->where('id', $this->destination)
                ->orWhere('name', 'like', "%{$this->destination}%")
                ->orWhereHas('country', fn ($country) => $country->where('name', 'like', "%{$this->destination}%"))))
            ->when($this->date !== '', fn ($query) => $query
                ->where(fn ($q) => $q->whereNull('available_from')->orWhereDate('available_from', '<=', $this->date))
                ->where(fn ($q) => $q->whereNull('available_to')->orWhereDate('available_to', '>=', $this->date)))
            ->when(is_numeric($this->minPrice), fn ($query) => $query->where('price', '>=', (float) $this->minPrice))
            ->when(is_numeric($this->maxPrice), fn ($query) => $query->where('price', '<=', (float) $this->maxPrice))
            ->when($this->duration !== '', fn ($query) => $query->where('duration', 'like', "%{$this->duration}%"))
            ->when($this->activity !== '', fn ($query) => $query->where(fn ($q) => $q
                ->where('title', 'like', "%{$this->activity}%")
                ->orWhere('description', 'like', "%{$this->activity}%")
                ->orWhere('features', 'like', "%{$this->activity}%")))
            ->when(is_numeric($this->guests), fn ($query) => $query->where('capacity_per_date', '>=', (int) $this->guests))
            ->latest()
            ->paginate(12);

        return view('livewire.frontend.tour-catalog', [
            'tours' => $tours,
            'destinations' => Destination::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }
}
