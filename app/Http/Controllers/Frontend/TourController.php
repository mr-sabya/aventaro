<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    //
    public function index()
    {
        return view('frontend.tour.index');
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
