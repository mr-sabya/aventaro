<?php
namespace Tests\Feature;
use App\Livewire\Backend\Contact\Inbox;
use App\Mail\ContactMessageReceived;
use App\Models\City;
use App\Models\ContactMessage;
use App\Models\Country;
use App\Models\Destination;
use App\Models\NewsPost;
use App\Models\NewsletterSubscriber;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class EngagementTest extends TestCase
{
 use RefreshDatabase;
 public function test_contact_and_appointment_forms_persist_notify_and_reject_honeypot():void
 {
  Mail::fake();$this->post(route('contact.store'),['type'=>'contact','name'=>'Guest','email'=>'guest@example.com','subject'=>'Trip question','message'=>'Please help me plan a tour.','website'=>''])->assertRedirect();
  $message=ContactMessage::firstOrFail();$this->assertSame('new',$message->status);Mail::assertSent(ContactMessageReceived::class);
  $this->post(route('appointment.store'),['type'=>'appointment','name'=>'Bot','email'=>'bot@example.com','message'=>'This should not be stored.','website'=>'spam'])->assertSessionHasErrors('website');$this->assertSame(1,ContactMessage::count());
  Livewire::test(Inbox::class)->call('open',$message->id);$this->assertSame('read',$message->fresh()->status);Livewire::test(Inbox::class)->call('markReplied',$message->id);$this->assertSame('replied',$message->fresh()->status);
 }
 public function test_newsletter_subscribe_resubscribe_and_unsubscribe_work():void
 {
  $this->post(route('newsletter.subscribe'),['newsletter_email'=>'Reader@Example.com','website'=>''])->assertRedirect();$subscriber=NewsletterSubscriber::firstOrFail();$this->assertTrue($subscriber->is_active);
  $this->get(route('newsletter.unsubscribe',$subscriber))->assertOk()->assertSeeText('reader@example.com');$this->post(route('newsletter.destroy',$subscriber))->assertRedirect(route('home'));$this->assertFalse($subscriber->fresh()->is_active);
  $this->post(route('newsletter.subscribe'),['newsletter_email'=>'reader@example.com','website'=>''])->assertRedirect();$this->assertTrue($subscriber->fresh()->is_active);
 }
 public function test_global_search_returns_tours_destinations_and_published_articles():void
 {
  $country=Country::create(['name'=>'Bangladesh','is_active'=>true]);$city=City::create(['country_id'=>$country->id,'name'=>'Dhaka','is_active'=>true]);
  Tour::create(['city_id'=>$city->id,'title'=>'Heritage Explorer Tour','description'=>'Heritage journey','price'=>10,'duration'=>'1 Day','thumbnail_image'=>'a.jpg','details_image'=>'b.jpg','is_active'=>true]);
  Destination::create(['city_id'=>$city->id,'name'=>'Heritage Destination','description'=>'Historic heritage','image'=>'d.jpg','is_active'=>true]);
  NewsPost::create(['title'=>'Heritage Travel Guide','author'=>'Admin','excerpt'=>'Heritage advice','content'=>'Article','image'=>'n.jpg','published_at'=>now(),'status'=>'published','is_active'=>true]);
  $this->get(route('search',['q'=>'Heritage']))->assertOk()->assertSeeText('Heritage Explorer Tour')->assertSeeText('Heritage Destination')->assertSeeText('Heritage Travel Guide');
 }
}
