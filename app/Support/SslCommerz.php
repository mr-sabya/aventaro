<?php

namespace App\Support;

use App\Models\Booking;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/** Talks to SSLCommerz: starts a payment and checks (server to server) that a payment really happened. */
class SslCommerz
{
    public function __construct(private PaymentGateway $gateway) {}

    public static function make(): self
    {
        return new self(PaymentGateway::sslcommerz());
    }

    public function baseUrl(): string
    {
        return $this->gateway->is_sandbox ? 'https://sandbox.sslcommerz.com' : 'https://securepay.sslcommerz.com';
    }

    /** The amount the customer is charged, in the gateway currency. */
    public function amountFor(Booking $booking): float
    {
        return round((float) $booking->total * (float) $this->gateway->rate, 2);
    }

    /** Start a payment and return the SSLCommerz page the customer should be sent to. */
    public function start(Booking $booking, string $transactionId): string
    {
        $response = Http::asForm()->timeout(25)->post($this->baseUrl().'/gwprocess/v4/api.php', [
            'store_id' => $this->gateway->store_id,
            'store_passwd' => $this->gateway->store_password,
            'total_amount' => $this->amountFor($booking),
            'currency' => $this->gateway->currency,
            'tran_id' => $transactionId,
            'success_url' => route('payment.sslcommerz.success'),
            'fail_url' => route('payment.sslcommerz.fail'),
            'cancel_url' => route('payment.sslcommerz.cancel'),
            'ipn_url' => route('payment.sslcommerz.ipn'),
            'cus_name' => $booking->name,
            'cus_email' => $booking->email,
            'cus_add1' => $booking->address ?: 'N/A',
            'cus_city' => 'N/A',
            'cus_country' => 'N/A',
            'cus_phone' => $booking->phone,
            'shipping_method' => 'NO',
            'num_of_item' => $booking->travellers,
            'product_name' => 'Tour booking '.$booking->reference,
            'product_category' => 'Travel',
            'product_profile' => 'general',
        ]);

        $url = $response->json('GatewayPageURL');
        if (! $response->successful() || $response->json('status') !== 'SUCCESS' || blank($url)) {
            throw new RuntimeException($response->json('failedreason') ?: 'SSLCommerz did not start the payment.');
        }

        return $url;
    }

    /**
     * Ask SSLCommerz whether a validation id is a real, paid payment for this booking.
     * Never trust the browser or the posted fields alone.
     */
    public function isPaid(Booking $booking, ?string $valId): bool
    {
        if (blank($valId)) {
            return false;
        }

        $response = Http::timeout(25)->get($this->baseUrl().'/validator/api/validationserverAPI.php', [
            'val_id' => $valId,
            'store_id' => $this->gateway->store_id,
            'store_passwd' => $this->gateway->store_password,
            'format' => 'json',
        ]);

        if (! $response->successful() || ! in_array($response->json('status'), ['VALID', 'VALIDATED'], true)) {
            return false;
        }
        if ($response->json('tran_id') !== $booking->transaction_id) {
            return false;
        }

        $paid = (float) ($response->json('currency_amount') ?? $response->json('amount'));
        $currency = $response->json('currency_type') ?? $response->json('currency');

        return abs($paid - $this->amountFor($booking)) < 0.01
            && (blank($currency) || strtoupper($currency) === strtoupper($this->gateway->currency));
    }
}
