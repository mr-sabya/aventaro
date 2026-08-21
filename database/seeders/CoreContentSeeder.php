<?php
namespace Database\Seeders;
use App\Models\BenefitItem; use App\Models\ContentPage; use App\Models\HeroSlide; use App\Models\SiteSetting; use Illuminate\Database\Seeder;
class CoreContentSeeder extends Seeder { public function run():void {
 SiteSetting::firstOrCreate([],['site_name'=>'Aventaro','tagline'=>'Travel & Tour Booking','email'=>'hello@example.com','header_button_text'=>'Explore Tours','header_button_url'=>'/tour-packages']);
 HeroSlide::firstOrCreate(['title_part_1'=>'Discover'],['subtitle'=>'Plan your next adventure','title_part_2'=>'the world','title_part_3'=>'with Aventaro','description'=>'Curated tours, trusted guides, and memorable destinations.','background_image'=>'hero/hero-bg.jpg','is_active'=>true,'order'=>1]);
 foreach(['Trusted travel experts','Secure tour booking','Helpful customer support'] as $i=>$title) BenefitItem::firstOrCreate(['title'=>$title],['sort_order'=>$i+1,'is_active'=>true]);
 ContentPage::firstOrCreate(['slug'=>'about-us'],['title'=>'About Aventaro','breadcrumb_title'=>'About Us','content'=>'We create memorable journeys with trusted local experts.','sections'=>[],'is_active'=>true]);
} }
