<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_content_pages_and_custom_404_render(): void
    {
        $this->get('/about-us')->assertOk()->assertSee('Quality, service, and memorable travel');
        $this->get('/faq')->assertOk()->assertSee('How do I book a tour?');
        $this->get('/privacy-policy')->assertOk()->assertSee('We do not sell personal information');
        $this->get('/terms-and-conditions')->assertOk()->assertSee('Terms and Conditions');
        $this->get('/this-page-does-not-exist')->assertNotFound()->assertSee('Page not found');
    }

    public function test_admin_can_update_page_breadcrumb_content_and_sections(): void
    {
        $admin=User::factory()->create(['is_admin'=>true]);
        $page=ContentPage::where('slug','about-us')->firstOrFail();
        $this->actingAs($admin)->put(route('admin.content-pages.update',$page),[
            'title'=>'Our Story','breadcrumb_title'=>'Meet Aventaro','meta_title'=>'Our Story','meta_description'=>'Our company story','content'=>'Fresh editable copy','sections'=>json_encode(['promise_title'=>'A better promise','promises'=>['Personal service']]),'is_active'=>1,
        ])->assertRedirect();
        $this->get('/about-us')->assertOk()->assertSee('Meet Aventaro')->assertSee('Fresh editable copy')->assertSee('A better promise');
    }
}
