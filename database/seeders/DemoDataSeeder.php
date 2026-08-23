<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    private $now;

    public function run(): void
    {
        $this->now = now();
        $this->copyDemoImages();

        DB::transaction(function (): void {
            $this->seedSettingsAndSections();
            [$cities, $currencies, $languages] = $this->seedLocations();
            $destinations = $this->seedDestinations($cities, $currencies, $languages);
            $tours = $this->seedTours($cities);
            $this->seedTourContent($tours);
            $this->seedHomepageCollections();
            $this->seedBlog();
            $this->seedFooter();
            $this->seedOperationalDemoData($tours);
        });
    }

    private function seedSettingsAndSections(): void
    {
        DB::table('site_settings')->updateOrInsert(['id' => 1], [
            'site_name' => 'Aventaro', 'tagline' => 'Curated journeys, unforgettable stories',
            'phone' => '+880 1700 123456', 'email' => 'hello@aventaro.test',
            'address' => 'Gulshan Avenue, Dhaka, Bangladesh',
            'facebook_url' => 'https://facebook.com', 'instagram_url' => 'https://instagram.com',
            'twitter_url' => 'https://x.com', 'linkedin_url' => 'https://linkedin.com',
            'header_button_text' => 'Explore Tours', 'header_button_url' => '/tour-packages',
            'newsletter_title' => 'Get fresh travel inspiration', 'footer_about_title' => 'Travel better with Aventaro',
            'copyright_text' => '© '.date('Y').' Aventaro. All rights reserved.',
            'play_store_url' => '#', 'app_store_url' => '#', 'updated_at' => $this->now, 'created_at' => $this->now,
        ]);

        $slides = [
            ['Wander farther', 'Discover', 'Hidden', 'Wonders'],
            ['Made for explorers', 'Find', 'Your Next', 'Adventure'],
            ['Travel with confidence', 'Meet', 'The World', 'Up Close'],
            ['Small groups, big memories', 'Journey', 'Beyond the', 'Ordinary'],
            ['Your story starts here', 'Escape', 'Into Something', 'Remarkable'],
        ];
        foreach ($slides as $i => [$subtitle, $one, $two, $three]) {
            DB::table('hero_slides')->updateOrInsert(['title_part_1' => $one], [
                'subtitle' => $subtitle, 'title_part_2' => $two, 'title_part_3' => $three,
                'description' => 'Handpicked places, local experts, and flexible experiences designed around the way you love to travel.',
                'background_image' => 'demo/hero-'.(($i % 3) + 1).'.jpg', 'is_active' => true, 'order' => $i + 1,
                'updated_at' => $this->now, 'created_at' => $this->now,
            ]);
        }

        $singletons = [
            'about_sections' => ['id' => 1, 'subtitle' => 'About Aventaro', 'title' => 'Thoughtful journeys, made personal', 'description' => 'We connect curious travellers with remarkable places and trusted local hosts.', 'quote' => 'The best journeys leave you with a new way of seeing the world.', 'main_image' => 'demo/about.jpg', 'experience_years' => 12, 'button_text' => 'Our Story', 'button_url' => '/about-us', 'features' => json_encode(['Expertly planned itineraries', 'Responsible local experiences', 'Support before and during your trip'])],
            'brand_sections' => ['id' => 1, 'text' => 'Trusted by travellers and tourism partners worldwide'],
            'trending_destination_sections' => ['id' => 1, 'subtitle' => 'Trending Destinations', 'title' => 'Places everyone is talking about', 'button_text' => 'View All Destinations', 'button_url' => '/destinations'],
            'featured_tour_sections' => ['id' => 1, 'subtitle' => 'Featured Experiences', 'title' => 'Our most-loved adventures', 'description' => 'Flexible, authentic trips chosen by our travel specialists.'],
            'discover_sections' => ['id' => 1, 'subtitle' => 'Limited-time escapes', 'title' => 'Hot deals for your next departure', 'description' => 'Save on selected small-group journeys while spaces last.', 'button_text' => 'Explore Deals', 'button_url' => '/tour-packages', 'background_image' => 'demo/discover.jpg'],
        ];
        foreach ($singletons as $table => $values) {
            $id = $values['id'];
            unset($values['id']);
            DB::table($table)->updateOrInsert(['id' => $id], $values + ['updated_at' => $this->now, 'created_at' => $this->now]);
        }

        DB::table('app_promotions')->updateOrInsert(['title' => 'Your whole journey in one place'], [
            'subtitle' => 'Aventaro Mobile', 'description' => 'Save favourites, review itineraries, and keep booking details close wherever you go.',
            'background_image' => 'demo/app-bg.jpg', 'app_image' => 'demo/app.png', 'play_store_url' => '#', 'app_store_url' => '#',
            'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now,
        ]);
        DB::table('promo_banners')->updateOrInsert(['title' => 'Save 15% on selected summer escapes'], [
            'subtitle' => 'Seasonal offer', 'button_text' => 'See the Deals', 'button_url' => '/tour-packages',
            'background_image' => 'demo/promo.jpg', 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now,
        ]);
    }

    private function seedLocations(): array
    {
        $places = [
            ['Japan','Tokyo','JPY','Japanese Yen','¥','ja','Japanese'], ['Indonesia','Bali','IDR','Indonesian Rupiah','Rp','id','Indonesian'],
            ['Italy','Rome','EUR','Euro','€','it','Italian'], ['France','Paris','EUR','Euro','€','fr','French'],
            ['Switzerland','Interlaken','CHF','Swiss Franc','CHF','de','German'], ['Greece','Santorini','EUR','Euro','€','el','Greek'],
            ['Turkey','Istanbul','TRY','Turkish Lira','₺','tr','Turkish'], ['Morocco','Marrakesh','MAD','Moroccan Dirham','د.م.','ar','Arabic'],
            ['Egypt','Cairo','EGP','Egyptian Pound','E£','en','English'], ['Thailand','Bangkok','THB','Thai Baht','฿','th','Thai'],
            ['Vietnam','Hanoi','VND','Vietnamese Dong','₫','vi','Vietnamese'], ['Nepal','Kathmandu','NPR','Nepalese Rupee','रू','ne','Nepali'],
            ['United Arab Emirates','Dubai','AED','UAE Dirham','د.إ','es','Spanish'], ['Australia','Sydney','AUD','Australian Dollar','A$','pt','Portuguese'],
            ['New Zealand','Queenstown','NZD','New Zealand Dollar','NZ$','ko','Korean'], ['Canada','Vancouver','CAD','Canadian Dollar','C$','zh','Chinese'],
            ['United States','New York','USD','US Dollar','$','nl','Dutch'], ['Mexico','Cancun','MXN','Mexican Peso','MX$','ms','Malay'],
            ['Peru','Cusco','PEN','Peruvian Sol','S/','hi','Hindi'], ['South Africa','Cape Town','ZAR','South African Rand','R','bn','Bengali'],
        ];
        $currencies = $languages = $cities = [];
        foreach ($places as [$country, $city, $code, $currency, $symbol, $langCode, $language]) {
            DB::table('countries')->updateOrInsert(['slug' => Str::slug($country)], ['name' => $country, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            $countryId = DB::table('countries')->where('slug', Str::slug($country))->value('id');
            DB::table('cities')->updateOrInsert(['country_id' => $countryId, 'slug' => Str::slug($city)], ['name' => $city, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            $cities[] = DB::table('cities')->where('country_id', $countryId)->where('slug', Str::slug($city))->value('id');
            DB::table('currencies')->updateOrInsert(['code' => $code], ['name' => $currency, 'symbol' => $symbol, 'exchange_rate' => $code === 'USD' ? 1 : 1, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            $currencies[] = DB::table('currencies')->where('code', $code)->value('id');
            DB::table('languages')->updateOrInsert(['code' => $langCode], ['name' => $language, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            $languages[] = DB::table('languages')->where('code', $langCode)->value('id');
        }
        return [$cities, $currencies, $languages];
    }

    private function seedDestinations(array $cities, array $currencies, array $languages): array
    {
        $names = ['Tokyo Neon & Tradition','Bali Island Retreat','Eternal Rome','Parisian Weekends','Swiss Alpine Lakes','Santorini Sunsets','Istanbul Crossroads','Marrakesh Medina','Cairo & the Pyramids','Bangkok After Dark','Hanoi Heritage Quarter','Kathmandu Himalayan Gateway','Dubai City of Tomorrow','Sydney Harbour Life','Queenstown Adventure Country','Vancouver Coast & Mountains','New York City Icons','Cancun Caribbean Shores','Cusco & the Sacred Valley','Cape Town Coastal Escape'];
        $ids = [];
        foreach ($names as $i => $name) {
            $slug = Str::slug($name);
            DB::table('destinations')->updateOrInsert(['slug' => $slug], [
                'city_id' => $cities[$i], 'currency_id' => $currencies[$i], 'name' => $name,
                'image' => 'demo/destination-'.(($i % 6) + 1).'.jpg', 'image_alt' => $name.' travel destination',
                'description' => 'Discover local flavours, memorable landmarks, and carefully chosen experiences in '.$name.'.',
                'visa_requirements' => 'Requirements depend on nationality; confirm current entry rules before departure.',
                'area' => number_format(900 + ($i * 137)).' km²', 'map_embed_url' => 'https://www.google.com/maps?q='.urlencode($name).'&output=embed',
                'features' => json_encode(['Local expert recommendations', 'Flexible sightseeing options', 'Authentic food and culture']),
                'is_trending' => $i < 12, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now,
            ]);
            $id = DB::table('destinations')->where('slug', $slug)->value('id');
            $ids[] = $id;
            DB::table('destination_language')->insertOrIgnore(['destination_id' => $id, 'language_id' => $languages[$i]]);
            DB::table('destination_language')->insertOrIgnore(['destination_id' => $id, 'language_id' => $languages[8]]);
        }
        foreach (range(1, 20) as $i) {
            $question = "What should I know before visiting destination {$i}?";
            DB::table('destination_faqs')->updateOrInsert(['question' => $question], ['answer' => 'Pack for the season, keep a copy of your travel documents, and allow time for local experiences.', 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            $faqId = DB::table('destination_faqs')->where('question', $question)->value('id');
            DB::table('destination_faq')->updateOrInsert(['destination_id' => $ids[$i - 1], 'destination_faq_id' => $faqId], ['updated_at' => $this->now, 'created_at' => $this->now]);
        }
        return $ids;
    }

    private function seedTours(array $cities): array
    {
        $titles = ['Tokyo Culture & Cuisine','Bali Wellness Escape','Classic Rome Discovery','Paris Art & Patisserie','Swiss Peaks by Rail','Santorini Island Romance','Istanbul Grand Bazaar Trail','Marrakesh Desert Doorway','Egyptian Wonders Journey','Bangkok Temples & Markets','Hanoi Food & Heritage','Everest Panorama Trek','Dubai Desert & Skyline','Sydney Coast Explorer','Queenstown Thrill Week','Vancouver Nature Break','New York Highlights','Cancun Reef Adventure','Machu Picchu Explorer','Cape Town & Winelands'];
        $ids = [];
        foreach ($titles as $i => $title) {
            $slug = Str::slug($title);
            $price = 349 + ($i * 73);
            DB::table('tours')->updateOrInsert(['slug' => $slug], [
                'city_id' => $cities[$i], 'address' => 'Central visitor meeting point', 'title' => $title,
                'description' => 'A balanced small-group journey combining signature sights, free time, and meaningful local encounters.',
                'price' => $price, 'old_price' => $price + 140, 'duration' => (($i % 7) + 3).' Days / '.(($i % 7) + 2).' Nights',
                'available_from' => now()->addDays(7)->toDateString(), 'available_to' => now()->addYear()->toDateString(), 'capacity_per_date' => 20,
                'countries_covered' => '1 Country', 'thumbnail_image' => 'demo/tour-'.(($i % 20) + 1).'.jpg',
                'details_image' => 'demo/tour-'.(($i % 20) + 1).'.jpg', 'image_alt' => $title,
                'features' => json_encode(['Curated daily itinerary', 'Experienced local guide', 'Small group atmosphere', 'Flexible free time']),
                'map_embed_url' => 'https://www.google.com/maps?q='.urlencode($title).'&output=embed',
                'rating' => 4.5 + (($i % 5) / 10), 'review_count' => 1, 'is_featured' => $i < 12, 'is_hot_deal' => $i % 2 === 0,
                'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now,
            ]);
            $ids[] = DB::table('tours')->where('slug', $slug)->value('id');
        }
        return $ids;
    }

    private function seedTourContent(array $tours): void
    {
        $amenities = ['Airport pickup','Breakfast daily','Boutique accommodation','Local guide','Entry tickets','Wi-Fi','Small group','Scenic transport','Luggage transfer','24/7 assistance'];
        foreach ($amenities as $i => $name) {
            DB::table('amenities')->updateOrInsert(['name' => $name], ['icon_class' => ['flaticon-car','flaticon-food','flaticon-hotel','flaticon-tour-guide','flaticon-ticket','flaticon-wifi','flaticon-group','flaticon-train','flaticon-bag','flaticon-support'][$i], 'updated_at' => $this->now, 'created_at' => $this->now]);
        }
        $amenityIds = DB::table('amenities')->whereIn('name', $amenities)->pluck('id')->all();
        foreach ($tours as $i => $tourId) {
            foreach ([1 => 'Arrival and neighbourhood welcome', 2 => 'Signature sights with a local expert', 3 => 'Markets, flavours, and free exploration'] as $day => $title) {
                DB::table('tour_plans')->updateOrInsert(['tour_id' => $tourId, 'day_number' => $day], ['title' => $title, 'description' => 'Enjoy a relaxed, thoughtfully paced day with guided highlights and time to explore independently.', 'updated_at' => $this->now, 'created_at' => $this->now]);
            }
            foreach (array_slice($amenityIds, $i % 5, 5) as $amenityId) DB::table('amenity_tour')->insertOrIgnore(['tour_id' => $tourId, 'amenity_id' => $amenityId]);
            DB::table('tour_reviews')->updateOrInsert(['tour_id' => $tourId, 'email' => "traveller{$i}@example.test"], [
                'user_id' => null, 'name' => 'Demo Traveller '.($i + 1), 'phone' => null, 'location' => ['Dhaka','London','Toronto','Sydney'][$i % 4],
                'image' => null, 'rating' => 4 + ($i % 2), 'comment' => 'Well organised, friendly guide, and just the right mix of planned activities and free time.',
                'is_approved' => true, 'updated_at' => $this->now, 'created_at' => $this->now,
            ]);
        }
    }

    private function seedHomepageCollections(): void
    {
        $benefits = ['Local expertise','Flexible booking','Small groups','Handpicked stays','Transparent pricing','24/7 support','Responsible travel','Authentic encounters','Secure checkout','Curated routes','Trusted guides','Easy planning','Dietary support','Family friendly','Solo welcome','Private options','Airport transfers','Quality assured','Smart itineraries','Memories guaranteed'];
        foreach ($benefits as $i => $title) DB::table('benefit_items')->updateOrInsert(['title' => $title], ['icon' => 'flaticon-check', 'sort_order' => $i + 1, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
        foreach (range(1, 20) as $i) {
            DB::table('partners')->updateOrInsert(['name' => "Travel Partner {$i}"], ['image' => 'demo/brand-'.(($i % 5) + 1).'.png', 'url' => '#', 'sort_order' => $i, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            DB::table('team_members')->updateOrInsert(['slug' => "travel-specialist-{$i}"], ['name' => "Travel Specialist {$i}", 'role' => ['Tour Designer','Local Guide','Destination Expert','Guest Experience Lead'][$i % 4], 'bio' => 'A passionate travel professional who loves turning thoughtful details into seamless, memorable journeys.', 'email' => "guide{$i}@aventaro.test", 'phone' => '+880 1700 '.str_pad((string) $i, 6, '0', STR_PAD_LEFT), 'experience' => (3 + $i).' years', 'image' => 'demo/team-'.(($i % 12) + 1).'.jpg', 'image_alt' => "Travel Specialist {$i}", 'facebook_url' => '#', 'twitter_url' => '#', 'instagram_url' => '#', 'sort_order' => $i, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            DB::table('testimonials')->updateOrInsert(['name' => "Happy Traveller {$i}"], ['location' => ['Dhaka','Singapore','London','Toronto'][$i % 4], 'quote' => 'Every detail felt considered. We saw the highlights, found places we would never have discovered alone, and never felt rushed.', 'image' => 'demo/testimonial-'.(($i % 4) + 1).'.png', 'rating' => 5, 'sort_order' => $i, 'is_active' => true, 'is_approved' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            DB::table('travel_categories')->updateOrInsert(['name' => "Travel Style {$i}"], ['icon_image' => 'demo/category-'.(($i % 8) + 1).'.svg', 'tour_count' => 4 + $i, 'starting_price' => 249 + ($i * 20), 'url' => '/tour-packages', 'sort_order' => $i, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
        }
    }

    private function seedBlog(): void
    {
        $categoryNames = ['Travel Guides','Food & Culture','Adventure','Planning','Responsible Travel'];
        foreach ($categoryNames as $name) DB::table('news_categories')->updateOrInsert(['slug' => Str::slug($name)], ['name' => $name, 'description' => "Stories and practical ideas about {$name}.", 'updated_at' => $this->now, 'created_at' => $this->now]);
        $categoryIds = DB::table('news_categories')->whereIn('slug', array_map(fn ($name) => Str::slug($name), $categoryNames))->pluck('id')->all();
        $tagNames = ['city break','beaches','mountains','food','photography','budget','luxury','families','solo travel','couples'];
        foreach ($tagNames as $tag) DB::table('news_tags')->updateOrInsert(['slug' => Str::slug($tag)], ['name' => Str::title($tag), 'updated_at' => $this->now, 'created_at' => $this->now]);
        $tagIds = DB::table('news_tags')->whereIn('slug', array_map(fn ($name) => Str::slug($name), $tagNames))->pluck('id')->all();
        foreach (range(1, 20) as $i) {
            $title = ['How to Plan a Trip You Will Actually Enjoy','A Local Food Lover’s Weekend Guide','Small Ways to Travel More Responsibly','The Art of Packing Light','Beautiful Places Worth Waking Up Early For'][($i - 1) % 5]." #{$i}";
            $slug = Str::slug($title);
            DB::table('news_posts')->updateOrInsert(['slug' => $slug], ['news_category_id' => $categoryIds[($i - 1) % count($categoryIds)], 'title' => $title, 'author' => 'Aventaro Editorial', 'excerpt' => 'Practical ideas and honest inspiration to help you make more of every journey.', 'content' => '<p>Great travel starts with curiosity and a little preparation. This guide shares simple, field-tested ideas for creating a journey with room for both discovery and rest.</p><h2>Start with what matters</h2><p>Choose a few meaningful experiences, leave space between them, and ask local people for recommendations.</p>', 'image' => 'demo/news-'.(($i % 13) + 1).'.jpg', 'image_alt' => $title, 'published_at' => now()->subDays($i), 'is_active' => true, 'status' => 'published', 'view_count' => 50 + ($i * 17), 'updated_at' => $this->now, 'created_at' => $this->now]);
            $postId = DB::table('news_posts')->where('slug', $slug)->value('id');
            DB::table('news_post_tag')->insertOrIgnore(['news_post_id' => $postId, 'news_tag_id' => $tagIds[($i - 1) % count($tagIds)]]);
            DB::table('news_post_tag')->insertOrIgnore(['news_post_id' => $postId, 'news_tag_id' => $tagIds[$i % count($tagIds)]]);
        }
    }

    private function seedFooter(): void
    {
        $footerLinks = [
            ['Useful Links', 'All Destinations', '/destinations'], ['Useful Links', 'Tour Packages', '/tour-packages'],
            ['Useful Links', 'Travel News', '/news'], ['Useful Links', 'Our Team', '/team'], ['Useful Links', 'Contact Support', '/contact-us'],
            ['About Aventaro', 'About Us', '/about-us'], ['About Aventaro', 'Frequently Asked Questions', '/faq'],
            ['About Aventaro', 'Privacy Policy', '/privacy-policy'], ['About Aventaro', 'Terms & Conditions', '/terms-and-conditions'],
            ['About Aventaro', 'Contact Us', '/contact-us'],
        ];
        foreach ($footerLinks as $i => [$group, $label, $url]) {
            DB::table('footer_links')->updateOrInsert(['group_name' => $group, 'label' => $label], ['url' => $url, 'sort_order' => $i + 1, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
        }
        foreach (range(1, 20) as $i) {
            DB::table('footer_galleries')->updateOrInsert(['alt_text' => "Traveller gallery image {$i}"], ['image' => 'demo/tour-'.(($i % 20) + 1).'.jpg', 'url' => '/destinations', 'sort_order' => $i, 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
        }
    }

    private function seedOperationalDemoData(array $tours): void
    {
        foreach (range(1, 20) as $i) {
            $code = 'DEMO'.str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            DB::table('coupons')->updateOrInsert(['code' => $code], ['type' => $i % 2 ? 'percent' : 'fixed', 'value' => $i % 2 ? 10 : 50, 'minimum_total' => 300, 'usage_limit' => 100, 'used_count' => $i, 'starts_at' => now()->subMonth(), 'expires_at' => now()->addYear(), 'is_active' => true, 'updated_at' => $this->now, 'created_at' => $this->now]);
            $couponId = DB::table('coupons')->where('code', $code)->value('id');
            $unit = 349 + (($i - 1) * 73); $travellers = ($i % 4) + 1; $subtotal = $unit * $travellers; $discount = $i % 2 ? $subtotal * .1 : 50;
            DB::table('bookings')->updateOrInsert(['reference' => 'AVT-DEMO-'.str_pad((string) $i, 4, '0', STR_PAD_LEFT)], ['cancellation_token' => hash('sha256', "aventaro-demo-booking-{$i}"), 'tour_id' => $tours[$i - 1], 'coupon_id' => $couponId, 'travel_date' => now()->addDays(20 + $i)->toDateString(), 'travellers' => $travellers, 'name' => "Demo Guest {$i}", 'email' => "guest{$i}@example.test", 'phone' => '+880 1800 '.str_pad((string) $i, 6, '0', STR_PAD_LEFT), 'address' => 'Dhaka, Bangladesh', 'notes' => 'Demo booking created by the sample data seeder.', 'unit_price' => $unit, 'subtotal' => $subtotal, 'discount' => $discount, 'total' => $subtotal - $discount, 'coupon_code' => $code, 'status' => ['pending','confirmed','completed','cancelled'][$i % 4], 'payment_method' => $i % 2 ? 'pay_later' : 'bank_transfer', 'payment_status' => $i % 3 ? 'unpaid' : 'paid', 'admin_notes' => 'Safe to edit or remove.', 'confirmed_at' => $i % 4 === 1 ? now() : null, 'cancelled_at' => $i % 4 === 3 ? now() : null, 'completed_at' => $i % 4 === 2 ? now() : null, 'refunded_at' => null, 'updated_at' => $this->now, 'created_at' => $this->now]);
            DB::table('contact_messages')->updateOrInsert(['email' => "contact{$i}@example.test", 'subject' => "Demo enquiry {$i}"], ['type' => $i % 4 ? 'contact' : 'appointment', 'name' => "Demo Contact {$i}", 'phone' => '+880 1900 '.str_pad((string) $i, 6, '0', STR_PAD_LEFT), 'message' => 'I would like help choosing the right itinerary and departure date.', 'status' => ['new','read','replied'][$i % 3], 'ip_address' => '127.0.0.1', 'user_agent' => 'Demo data seeder', 'read_at' => $i % 3 ? now() : null, 'replied_at' => $i % 3 === 2 ? now() : null, 'updated_at' => $this->now, 'created_at' => $this->now]);
            DB::table('newsletter_subscribers')->updateOrInsert(['email' => "subscriber{$i}@example.test"], ['unsubscribe_token' => hash('sha256', "aventaro-demo-subscriber-{$i}"), 'is_active' => true, 'subscribed_at' => now()->subDays($i), 'unsubscribed_at' => null, 'updated_at' => $this->now, 'created_at' => $this->now]);
        }
    }

    private function copyDemoImages(): void
    {
        $files = [
            'hero/03.jpg' => 'hero-1.jpg', 'hero/04.jpg' => 'hero-2.jpg', 'hero/05.jpg' => 'hero-3.jpg',
            'about/03.jpg' => 'about.jpg', 'tour/new/bg.jpg' => 'discover.jpg', 'cta/cta-bg-3.jpg' => 'promo.jpg',
            'cta/cta-apps-bg.jpg' => 'app-bg.jpg', 'cta/mobile-app.png' => 'app.png',
        ];
        foreach ([3, 4, 5] as $i => $source) $files['destinations/'.str_pad((string) $source, 2, '0', STR_PAD_LEFT).'.jpg'] = 'destination-'.($i + 1).'.jpg';
        foreach ([24, 25, 26] as $i => $source) $files['tour/'.str_pad((string) $source, 2, '0', STR_PAD_LEFT).'.jpg'] = 'destination-'.($i + 4).'.jpg';
        $tourSources = array_merge(range(1, 12), range(16, 23));
        foreach ($tourSources as $i => $source) $files['tour/'.str_pad((string) $source, 2, '0', STR_PAD_LEFT).'.jpg'] = 'tour-'.($i + 1).'.jpg';
        foreach (range(1, 12) as $i) $files['team/'.str_pad((string) $i, 2, '0', STR_PAD_LEFT).'.jpg'] = "team-{$i}.jpg";
        foreach (range(1, 5) as $i) $files["news/post-{$i}.jpg"] = "news-{$i}.jpg";
        foreach (range(8, 13) as $source) $files['news/news-'.str_pad((string) $source, 2, '0', STR_PAD_LEFT).'.jpg'] = 'news-'.($source - 2).'.jpg';
        $files['news/pp1.jpg'] = 'news-12.jpg';
        $files['news/pp2.jpg'] = 'news-13.jpg';
        foreach (range(1, 5) as $i) $files['brand/'.str_pad((string) $i, 2, '0', STR_PAD_LEFT).'.png'] = "brand-{$i}.png";
        foreach (range(1, 4) as $i) $files['testimonial/client-'.str_pad((string) $i, 2, '0', STR_PAD_LEFT).'.png'] = "testimonial-{$i}.png";
        $categoryIcons = [1 => 'icon-01.svg', 2 => 'icon-02.svg', 3 => 'icon-3.svg', 4 => 'icon-4.svg', 5 => 'icon-5.svg', 6 => 'icon-6.svg', 7 => 'icon-7.svg', 8 => 'icon-8.svg'];
        foreach ($categoryIcons as $i => $source) $files[$source] = "category-{$i}.svg";

        foreach ($files as $source => $target) {
            $sourcePath = public_path('assets/frontend/img/'.$source);
            if (is_file($sourcePath) && ! Storage::disk('public')->exists('demo/'.$target)) {
                Storage::disk('public')->put('demo/'.$target, file_get_contents($sourcePath));
            }
        }
    }
}
