<?php

namespace Tests\Feature;

use App\Models\NewsCategory;
use App\Models\NewsPost;
use App\Models\NewsTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_blog_only_shows_published_posts_and_filters_taxonomy(): void
    {
        $category=NewsCategory::create(['name'=>'Travel Tips']);$tag=NewsTag::create(['name'=>'Family']);
        $published=NewsPost::create(['news_category_id'=>$category->id,'title'=>'Published Family Guide','author'=>'Editor','excerpt'=>'Useful family advice.','content'=>'Complete article content.','image'=>'news/a.jpg','published_at'=>now()->subMinute(),'is_active'=>true,'status'=>'published']);$published->tags()->attach($tag);
        NewsPost::create(['title'=>'Secret Draft','author'=>'Editor','excerpt'=>'Not public.','content'=>'Draft.','image'=>'news/b.jpg','published_at'=>now(),'is_active'=>false,'status'=>'draft']);

        $this->get(route('news.index',['category'=>$category->slug,'tag'=>$tag->slug,'search'=>'Family']))->assertOk()->assertSeeText('Published Family Guide')->assertDontSeeText('Secret Draft');
        $this->get(route('news.show',$published))->assertOk()->assertSeeText('Complete article content.');
        $this->assertSame(1,$published->fresh()->view_count);
    }

    public function test_admin_can_create_a_published_tagged_article(): void
    {
        Storage::fake('public');$admin=User::factory()->create(['is_admin'=>true]);$category=NewsCategory::create(['name'=>'Destinations']);$tag=NewsTag::create(['name'=>'Asia']);
        $this->actingAs($admin)->post(route('admin.news.store'),['news_category_id'=>$category->id,'title'=>'Admin Published Story','author'=>'Admin','excerpt'=>'Story excerpt.','content'=>'Story body.','image'=>UploadedFile::fake()->image('story.jpg'),'status'=>'published','published_at'=>now()->format('Y-m-d H:i:s'),'tags'=>[$tag->id]])->assertRedirect(route('admin.news.index'));
        $post=NewsPost::firstOrFail();$this->assertSame('published',$post->status);$this->assertTrue($post->tags->contains($tag));Storage::disk('public')->assertExists($post->image);
    }
}
