<?php

namespace Tests\Feature;

use App\Livewire\Frontend\TourCatalog;
use App\Models\City;
use App\Models\Country;
use App\Models\Destination;
use App\Models\DestinationFaq;
use App\Models\Tour;
use App\Models\TourReview;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    private function location(): array
    {
        $country = Country::create(['name' => 'Bangladesh', 'is_active' => true]);
        $city = City::create(['country_id' => $country->id, 'name' => 'Dhaka', 'is_active' => true]);

        return [$country, $city];
    }

    private function tour(City $city, array $attributes = []): Tour
    {
        return Tour::create(array_merge([
            'city_id' => $city->id,
            'title' => 'Dhaka Discovery Tour',
            'description' => 'Explore the city.',
            'price' => 150,
            'duration' => '3 Days',
            'thumbnail_image' => 'tours/thumbnails/test.jpg',
            'details_image' => 'tours/details/test.jpg',
            'is_active' => true,
        ], $attributes));
    }

    public function test_tour_listing_filters_and_slug_detail_page_work(): void
    {
        [, $city] = $this->location();
        $tour = $this->tour($city, [
            'available_from' => '2026-09-01',
            'available_to' => '2026-09-30',
        ]);
        $this->tour($city, ['title' => 'Hidden Inactive Tour', 'is_active' => false]);

        $this->get(route('tour.index', ['search' => 'Discovery', 'date' => '2026-09-15', 'max_price' => 200]))
            ->assertOk()
            ->assertSeeText($tour->title)
            ->assertDontSeeText('Hidden Inactive Tour');

        $this->get(route('tour.show', $tour))
            ->assertOk()
            ->assertSeeText($tour->title)
            ->assertSeeText('3 Days');
    }

    public function test_tour_catalog_filters_results_live(): void
    {
        [, $city] = $this->location();
        $matching = $this->tour($city, ['title' => 'Live Search Adventure']);
        $this->tour($city, ['title' => 'Different Cultural Journey']);

        Livewire::test(TourCatalog::class)
            ->assertSee($matching->title)
            ->set('search', 'Live Search')
            ->assertSee($matching->title)
            ->assertDontSee('Different Cultural Journey')
            ->set('maxPrice', '100')
            ->assertSee('No tours found')
            ->call('clearFilters')
            ->assertSee('Different Cultural Journey');
    }

    public function test_review_submission_is_pending_until_approved(): void
    {
        [, $city] = $this->location();
        $tour = $this->tour($city);

        $this->post(route('tour.reviews.store', $tour), [
            'name' => 'Guest Reviewer',
            'email' => 'guest@example.com',
            'rating' => 5,
            'comment' => 'A memorable tour.',
        ])->assertRedirect();

        $review = TourReview::firstOrFail();
        $this->assertFalse($review->is_approved);
        $this->get(route('tour.show', $tour))->assertDontSeeText('A memorable tour.');

        $review->update(['is_approved' => true]);
        $this->get(route('tour.show', $tour))->assertSeeText('A memorable tour.');
    }

    public function test_destination_detail_displays_faq_and_matching_tours(): void
    {
        [, $city] = $this->location();
        $destination = Destination::create([
            'city_id' => $city->id,
            'name' => 'Historic Dhaka',
            'image' => 'destinations/test.jpg',
            'description' => 'A rich cultural destination.',
            'is_active' => true,
        ]);
        $faq = DestinationFaq::create(['question' => 'When should I visit?', 'answer' => 'During the dry season.', 'is_active' => true]);
        $destination->faqs()->attach($faq);
        $tour = $this->tour($city);

        $this->get(route('destination.index'))->assertOk()->assertSeeText($destination->name);
        $this->get(route('destination.show', $destination))
            ->assertOk()
            ->assertSeeText('A rich cultural destination.')
            ->assertSeeText('When should I visit?')
            ->assertSeeText($tour->title);
    }
}
