<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    //
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'destination' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
        ]);

        $tours = Tour::query()
            ->with('city.country')
            ->where('is_active', true)
            ->when($filters['search'] ?? null, fn ($query, $search) => $query
                ->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")))
            ->when($filters['destination'] ?? null, fn ($query, $destination) => $query
                ->whereHas('city', fn ($q) => $q->where('id', $destination)
                    ->orWhere('name', 'like', "%{$destination}%")
                    ->orWhereHas('country', fn ($country) => $country->where('name', 'like', "%{$destination}%"))))
            ->when($filters['date'] ?? null, fn ($query, $date) => $query
                ->where(fn ($q) => $q->whereNull('available_from')->orWhereDate('available_from', '<=', $date))
                ->where(fn ($q) => $q->whereNull('available_to')->orWhereDate('available_to', '>=', $date)))
            ->when($filters['min_price'] ?? null, fn ($query, $price) => $query->where('price', '>=', $price))
            ->when($filters['max_price'] ?? null, fn ($query, $price) => $query->where('price', '<=', $price))
            ->when($filters['duration'] ?? null, fn ($query, $duration) => $query->where('duration', 'like', "%{$duration}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.tour.index', [
            'tours' => $tours,
            'destinations' => Destination::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function show(Tour $tour)
    {
        abort_unless($tour->is_active, 404);

        $tour->load(['city.country', 'amenities', 'plans', 'reviews' => fn ($query) => $query->latest()]);
        $relatedTours = Tour::query()
            ->with('city.country')
            ->where('is_active', true)
            ->where('city_id', $tour->city_id)
            ->where('id', '!=', $tour->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('frontend.tour.show', compact('tour', 'relatedTours'));
    }

    public function storeReview(Request $request, Tour $tour)
    {
        abort_unless($tour->is_active, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        $tour->reviews()->create($validated + ['is_approved' => false]);

        return back()->with('success', 'Thank you. Your review was submitted for approval.');
    }
}
