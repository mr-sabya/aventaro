<?php

namespace Tests\Feature;

use App\Models\AppPromotion;
use App\Models\BenefitItem;
use App\Models\NewsPost;
use App\Models\PromoBanner;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\TravelCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomepageContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_all_active_remaining_cms_sections(): void
    {
        BenefitItem::create(['title'=>'Dynamic Benefit','sort_order'=>1,'is_active'=>true]);
        TeamMember::create(['name'=>'Dynamic Guide','role'=>'Guide','image'=>'team/guide.jpg','is_active'=>true]);
        TravelCategory::create(['name'=>'Dynamic Inspiration','icon_image'=>'categories/icon.jpg','tour_count'=>4,'starting_price'=>99,'is_active'=>true]);
        PromoBanner::create(['subtitle'=>'Dynamic Offer','title'=>'Dynamic Promotion','button_text'=>'Book','button_url'=>'/tour-packages','background_image'=>'promo/bg.jpg','is_active'=>true]);
        Testimonial::create(['name'=>'Dynamic Traveler','quote'=>'Dynamic testimonial quote.','rating'=>5,'is_active'=>true,'is_approved'=>true]);
        NewsPost::create(['title'=>'Dynamic Travel Article','author'=>'Editor','excerpt'=>'Dynamic article excerpt.','image'=>'news/post.jpg','published_at'=>now(),'is_active'=>true,'status'=>'published']);
        AppPromotion::create(['subtitle'=>'Download','title'=>'Dynamic App Promotion','is_active'=>true]);
        BenefitItem::create(['title'=>'Hidden Benefit','is_active'=>false]);

        $this->get('/')->assertOk()
            ->assertSeeText('Dynamic Benefit')->assertSeeText('Dynamic Guide')
            ->assertSeeText('Dynamic Inspiration')->assertSeeText('Dynamic Promotion')
            ->assertSeeText('Dynamic testimonial quote.')->assertSeeText('Dynamic Travel Article')
            ->assertSeeText('Dynamic App Promotion')->assertDontSeeText('Hidden Benefit');
    }

    public function test_admin_can_create_and_update_homepage_content(): void
    {
        Storage::fake('public');
        $admin=User::factory()->create(['is_admin'=>true]);

        $this->actingAs($admin)->post(route('admin.homepage-content.save','team'),[
            'name'=>'New Guide','role'=>'Tour Guide','image'=>UploadedFile::fake()->image('guide.jpg'),'sort_order'=>1,'is_active'=>1,
        ])->assertRedirect();

        $member=TeamMember::firstOrFail();
        Storage::disk('public')->assertExists($member->image);
        $this->actingAs($admin)->post(route('admin.homepage-content.save',['team',$member->id]),[
            'name'=>'Updated Guide','role'=>'Senior Guide','sort_order'=>2,'is_active'=>1,
        ])->assertRedirect();
        $this->assertSame('Updated Guide',$member->fresh()->name);
    }
}
