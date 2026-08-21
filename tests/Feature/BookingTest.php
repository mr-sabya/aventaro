<?php

namespace Tests\Feature;

use App\Livewire\Backend\Booking\Index as BookingManager;
use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function tour(array $attributes = []): Tour
    {
        $country = Country::create(['name' => 'Bangladesh', 'is_active' => true]);
        $city = City::create(['country_id' => $country->id, 'name' => 'Dhaka', 'is_active' => true]);
        return Tour::create(array_merge(['city_id'=>$city->id,'title'=>'Bookable Tour','description'=>'Test','price'=>100,'duration'=>'2 Days','available_from'=>'2026-09-01','available_to'=>'2026-09-30','capacity_per_date'=>3,'thumbnail_image'=>'test.jpg','details_image'=>'test.jpg','is_active'=>true],$attributes));
    }

    private function payload(array $attributes = []): array
    {
        return array_merge(['travel_date'=>'2026-09-15','travellers'=>2,'name'=>'Booking Guest','email'=>'guest@example.com','phone'=>'123456789','payment_method'=>'pay_later'],$attributes);
    }

    public function test_booking_calculates_coupon_total_and_sends_confirmation(): void
    {
        Mail::fake();
        $tour=$this->tour();
        $coupon=Coupon::create(['code'=>'SAVE10','type'=>'percent','value'=>10,'minimum_total'=>100,'usage_limit'=>5,'is_active'=>true]);

        $this->post(route('booking.store',$tour),$this->payload(['coupon_code'=>'save10']))->assertRedirect();
        $booking=Booking::firstOrFail();
        $this->assertSame('200.00',$booking->subtotal);
        $this->assertSame('20.00',$booking->discount);
        $this->assertSame('180.00',$booking->total);
        $this->assertSame(1,$coupon->fresh()->used_count);
        Mail::assertSent(BookingConfirmation::class,fn($mail)=>$mail->hasTo('guest@example.com'));
        $this->get(route('booking.show',$booking))->assertOk()->assertSeeText($booking->reference);
    }

    public function test_capacity_and_availability_are_enforced(): void
    {
        $tour=$this->tour();
        Booking::create(['reference'=>'AVT-EXISTING','cancellation_token'=>str_repeat('a',64),'tour_id'=>$tour->id,'travel_date'=>'2026-09-15','travellers'=>2,'name'=>'Existing','email'=>'old@example.com','phone'=>'1','unit_price'=>100,'subtotal'=>200,'total'=>200,'status'=>'confirmed','payment_method'=>'pay_later','payment_status'=>'unpaid']);

        $this->post(route('booking.store',$tour),$this->payload(['travellers'=>2]))->assertSessionHasErrors('travellers');
        $this->post(route('booking.store',$tour),$this->payload(['travel_date'=>'2026-10-01','travellers'=>1]))->assertSessionHasErrors('travel_date');
    }

    public function test_customer_cancellation_restores_coupon_and_admin_can_manage_status(): void
    {
        $tour=$this->tour();
        $coupon=Coupon::create(['code'=>'FIXED','type'=>'fixed','value'=>10,'used_count'=>1,'is_active'=>true]);
        $booking=Booking::create(['reference'=>'AVT-CANCELME','cancellation_token'=>str_repeat('b',64),'tour_id'=>$tour->id,'coupon_id'=>$coupon->id,'travel_date'=>'2026-09-15','travellers'=>1,'name'=>'Guest','email'=>'guest@example.com','phone'=>'1','unit_price'=>100,'subtotal'=>100,'discount'=>10,'total'=>90,'status'=>'confirmed','payment_method'=>'pay_later','payment_status'=>'unpaid']);

        $this->post(route('booking.cancel',$booking),['token'=>$booking->cancellation_token])->assertRedirect();
        $this->assertSame('cancelled',$booking->fresh()->status);
        $this->assertSame(0,$coupon->fresh()->used_count);

        Livewire::test(BookingManager::class)->call('setStatus',$booking->id,'completed')->assertHasNoErrors();
        $this->assertSame('completed',$booking->fresh()->status);
    }
}
