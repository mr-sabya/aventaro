<?php

namespace App\Livewire\Backend\Tour;

use App\Models\TourReview;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public string $search = '';
    public string $status = 'pending';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }

    public function approve(int $id): void
    {
        TourReview::findOrFail($id)->update(['is_approved' => true]);
        session()->flash('message', 'Review approved.');
    }

    public function unapprove(int $id): void
    {
        TourReview::findOrFail($id)->update(['is_approved' => false]);
        session()->flash('message', 'Review moved to pending.');
    }

    public function delete(int $id): void
    {
        TourReview::findOrFail($id)->delete();
        session()->flash('message', 'Review deleted.');
    }

    public function render()
    {
        $reviews = TourReview::query()->with('tour')
            ->when($this->status === 'pending', fn ($query) => $query->where('is_approved', false))
            ->when($this->status === 'approved', fn ($query) => $query->where('is_approved', true))
            ->when($this->search, fn ($query) => $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhereHas('tour', fn ($tour) => $tour->where('title', 'like', "%{$this->search}%"))))
            ->latest()->paginate(15);

        return view('livewire.backend.tour.review-manager', compact('reviews'));
    }
}
