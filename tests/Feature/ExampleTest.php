<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Destination;
use App\Models\FeaturedTourSection;
use App\Models\HeroSlide;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_homepage_renders_active_cms_content(): void
    {
        $country = Country::create(['name' => 'Bangladesh', 'is_active' => true]);
        $city = City::create(['country_id' => $country->id, 'name' => 'Dhaka', 'is_active' => true]);

        HeroSlide::create([
            'subtitle' => 'Dynamic hero subtitle',
            'title_part_1' => 'Explore',
            'title_part_2' => 'Dynamic',
            'title_part_3' => 'Adventures',
            'background_image' => 'hero-slides/example.jpg',
            'is_active' => true,
            'order' => 1,
        ]);

        Destination::create([
            'city_id' => $city->id,
            'name' => 'Dynamic Destination',
            'image' => 'destinations/example.jpg',
            'is_trending' => true,
            'is_active' => true,
        ]);

        FeaturedTourSection::create([
            'subtitle' => 'Featured Places',
            'title' => 'CMS Featured Tours',
            'description' => 'Tours selected in the admin panel.',
        ]);

        Tour::create([
            'city_id' => $city->id,
            'title' => 'Dynamic Featured Tour',
            'description' => 'A database-backed tour.',
            'price' => 125,
            'duration' => '3 Days',
            'thumbnail_image' => 'tours/thumbnails/example.jpg',
            'details_image' => 'tours/details/example.jpg',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSeeText('Dynamic hero subtitle')
            ->assertSeeText('Dynamic Destination')
            ->assertSeeText('CMS Featured Tours')
            ->assertSeeText('Dynamic Featured Tour');
    }
}
