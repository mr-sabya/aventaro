<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->validate(['search' => ['nullable', 'string', 'max:100']])['search'] ?? null;

        $destinations = Destination::query()
            ->with('city.country')
            ->where('is_active', true)
            ->when($search, fn ($query, $term) => $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$term}%")
                ->orWhereHas('city', fn ($city) => $city->where('name', 'like', "%{$term}%")
                    ->orWhereHas('country', fn ($country) => $country->where('name', 'like', "%{$term}%")))))
            ->orderByDesc('is_trending')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.destination.index', compact('destinations'));
    }

    public function show(Destination $destination)
    {
        abort_unless($destination->is_active, 404);

        $destination->load([
            'city.country',
            'currency',
            'languages',
            'faqs' => fn ($query) => $query->where('is_active', true),
        ]);

        $tours = Tour::query()
            ->with('city.country')
            ->where('is_active', true)
            ->where('city_id', $destination->city_id)
            ->latest()
            ->limit(8)
            ->get();

        return view('frontend.destination.show', compact('destination', 'tours'));
    }
}
