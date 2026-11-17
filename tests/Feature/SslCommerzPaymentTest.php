<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\City;
use App\Models\Country;
use App\Models\PaymentGateway;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SslCommerzPaymentTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function enable(array $extra = []): PaymentGateway
    {
        $gateway = PaymentGateway::sslcommerz();
        $gateway->update(array_merge(['store_id' => 'teststore', 'store_password' => 'secret-pass', 'is_active' => true, 'currency' => 'BDT', 'rate' => 100], $extra));

        return $gateway;
    }

    private function tour(): Tour
    {
        $country = Country::create(['name' => 'Bangladesh', 'is_active' => true]);
        $city = City::create(['country_id' => $country->id, 'name' => 'Dhaka', 'is_active' => true]);

        return Tour::create(['city_id' => $city->id, 'title' => 'Pay Tour', 'description' => 'Test', 'price' => 50, 'duration' => '2 Days', 'available_from' => '2026-09-01', 'available_to' => '2026-12-30', 'capacity_per_date' => 5, 'thumbnail_image' => 't.jpg', 'details_image' => 't.jpg', 'is_active' => true]);
    }

    private function payload(array $extra = []): array
    {
        return array_merge(['travel_date' => '2026-11-30', 'travellers' => 2, 'name' => 'Guest', 'email' => 'g@example.com', 'phone' => '0123456789', 'payment_method' => 'sslcommerz'], $extra);
    }

    public function test_admin_saves_keys_encrypted_and_never_sees_the_password_again(): void
    {
        $this->actingAs($this->admin())->put(route('admin.payments.update'), [
            'store_id' => 'mystore', 'store_password' => 'topsecret', 'mode' => 'sandbox', 'currency' => 'bdt', 'rate' => 120, 'is_active' => 1,
        ])->assertSessionHasNoErrors();

        $gateway = PaymentGateway::sslcommerz();
        $this->assertTrue($gateway->isReady());
        $this->assertSame('BDT', $gateway->currency);
        $this->assertNotSame('topsecret', \DB::table('payment_gateways')->value('store_password'));

        $this->actingAs($this->admin())->get(route('admin.payments.index'))->assertOk()->assertDontSee('topsecret');
    }

    public function test_it_cannot_be_switched_on_without_keys_and_blank_fields_keep_saved_keys(): void
    {
        $this->actingAs($this->admin())->put(route('admin.payments.update'), ['mode' => 'sandbox', 'currency' => 'BDT', 'rate' => 1, 'is_active' => 1])
            ->assertSessionHasErrors('store_id');
        $this->assertFalse(PaymentGateway::sslcommerz()->is_active);

        $this->enable();
        $this->actingAs($this->admin())->put(route('admin.payments.update'), ['store_id' => '', 'store_password' => '', 'mode' => 'live', 'currency' => 'BDT', 'rate' => 100, 'is_active' => 1]);
        $gateway = PaymentGateway::sslcommerz();
        $this->assertSame('secret-pass', $gateway->store_password);
        $this->assertFalse($gateway->is_sandbox);
    }

    public function test_payment_pages_need_an_admin(): void
    {
        $this->get(route('admin.payments.index'))->assertRedirect();
    }

    public function test_online_option_is_only_offered_when_ready_and_rejected_otherwise(): void
    {
        Mail::fake();
        $tour = $this->tour();

        $this->get(route('tour.show', $tour))->assertOk()->assertDontSee('Pay online (card');
        $this->post(route('booking.store', $tour), $this->payload())->assertSessionHasErrors('payment_method');

        $this->enable();
        $this->get(route('tour.show', $tour))->assertSee('Pay online (card');
    }

    public function test_booking_with_online_payment_goes_to_the_sslcommerz_page(): void
    {
        Mail::fake();
        $this->enable();
        Http::fake(['sandbox.sslcommerz.com/gwprocess/*' => Http::response(['status' => 'SUCCESS', 'GatewayPageURL' => 'https://sandbox.sslcommerz.com/EasyCheckOut/abc'])]);
        $tour = $this->tour();

        $this->post(route('booking.store', $tour), $this->payload())->assertRedirect('https://sandbox.sslcommerz.com/EasyCheckOut/abc');

        $booking = Booking::firstOrFail();
        $this->assertSame('unpaid', $booking->payment_status);
        $this->assertNotNull($booking->transaction_id);
        // 2 travellers x 50 = 100 price units x rate 100 = 10000.00 BDT, charged by the server.
        Http::assertSent(fn ($r) => str_contains($r->url(), 'gwprocess') && $r['total_amount'] == 10000 && $r['currency'] === 'BDT' && $r['tran_id'] === $booking->transaction_id);
    }

    private function pendingBooking(): Booking
    {
        Mail::fake();
        $this->enable();
        Http::fake(['sandbox.sslcommerz.com/gwprocess/*' => Http::response(['status' => 'SUCCESS', 'GatewayPageURL' => 'https://sandbox.sslcommerz.com/x'])]);
        $this->post(route('booking.store', $this->tour()), $this->payload());

        return Booking::firstOrFail();
    }

    public function test_a_verified_payment_marks_the_booking_paid_and_confirmed(): void
    {
        $booking = $this->pendingBooking();
        Http::fake(['sandbox.sslcommerz.com/validator/*' => Http::response(['status' => 'VALID', 'tran_id' => $booking->transaction_id, 'currency_amount' => '10000.00', 'currency_type' => 'BDT'])]);

        $this->post(route('payment.sslcommerz.success'), ['tran_id' => $booking->transaction_id, 'val_id' => 'VAL1', 'bank_tran_id' => 'BANK9'])
            ->assertRedirect(route('booking.show', $booking));

        $booking->refresh();
        $this->assertSame('paid', $booking->payment_status);
        $this->assertSame('confirmed', $booking->status);
        $this->assertSame('BANK9', $booking->gateway_reference);
        $this->assertNotNull($booking->paid_at);
    }

    public function test_a_forged_or_wrong_amount_payment_is_not_accepted(): void
    {
        $booking = $this->pendingBooking();

        // Posting success without a validation id proves nothing.
        $this->post(route('payment.sslcommerz.success'), ['tran_id' => $booking->transaction_id]);
        $this->assertSame('unpaid', $booking->fresh()->payment_status);

        // SSLCommerz says it is valid but for a smaller amount.
        Http::fake(['sandbox.sslcommerz.com/validator/*' => Http::response(['status' => 'VALID', 'tran_id' => $booking->transaction_id, 'currency_amount' => '1.00', 'currency_type' => 'BDT'])]);
        $this->post(route('payment.sslcommerz.ipn'), ['tran_id' => $booking->transaction_id, 'val_id' => 'VAL2']);
        $this->assertSame('unpaid', $booking->fresh()->payment_status);

        // SSLCommerz says it failed.
        Http::fake(['sandbox.sslcommerz.com/validator/*' => Http::response(['status' => 'INVALID_TRANSACTION'])]);
        $this->post(route('payment.sslcommerz.success'), ['tran_id' => $booking->transaction_id, 'val_id' => 'VAL3']);
        $this->assertSame('unpaid', $booking->fresh()->payment_status);
    }

    public function test_the_notification_can_settle_a_booking_and_failed_or_cancelled_return_to_the_booking(): void
    {
        $booking = $this->pendingBooking();

        $this->post(route('payment.sslcommerz.fail'), ['tran_id' => $booking->transaction_id])->assertRedirect(route('booking.show', $booking));
        $this->post(route('payment.sslcommerz.cancel'), ['tran_id' => $booking->transaction_id])->assertRedirect(route('booking.show', $booking));
        $this->post(route('payment.sslcommerz.cancel'), ['tran_id' => 'nope'])->assertRedirect(route('home'));

        Http::fake(['sandbox.sslcommerz.com/validator/*' => Http::response(['status' => 'VALIDATED', 'tran_id' => $booking->transaction_id, 'amount' => '10000.00', 'currency_type' => 'BDT'])]);
        $this->post(route('payment.sslcommerz.ipn'), ['tran_id' => $booking->transaction_id, 'val_id' => 'VAL4'])->assertOk();
        $this->assertSame('paid', $booking->fresh()->payment_status);
    }

    public function test_a_customer_can_pay_again_from_the_booking_page_and_paid_bookings_cannot(): void
    {
        $booking = $this->pendingBooking();
        $first = $booking->transaction_id;

        $this->get(route('booking.show', $booking))->assertSee('Pay online now');
        Http::fake(['sandbox.sslcommerz.com/gwprocess/*' => Http::response(['status' => 'SUCCESS', 'GatewayPageURL' => 'https://sandbox.sslcommerz.com/x'])]);
        $this->post(route('booking.pay', $booking))->assertRedirect('https://sandbox.sslcommerz.com/x');
        $this->assertNotSame($first, $booking->fresh()->transaction_id);

        $booking->update(['payment_status' => 'paid']);
        $this->post(route('booking.pay', $booking))->assertRedirect(route('booking.show', $booking));
        $this->get(route('booking.show', $booking))->assertDontSee('Pay online now');
    }

    public function test_a_gateway_error_leaves_the_booking_unpaid_with_a_message(): void
    {
        Mail::fake();
        $this->enable();
        Http::fake(['sandbox.sslcommerz.com/gwprocess/*' => Http::response(['status' => 'FAILED', 'failedreason' => 'Invalid Store ID'])]);

        $this->post(route('booking.store', $this->tour()), $this->payload())->assertRedirect(route('booking.show', Booking::firstOrFail()));
        $this->assertSame('unpaid', Booking::firstOrFail()->payment_status);
    }
}
