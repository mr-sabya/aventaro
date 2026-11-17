<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PaymentGateway;
use App\Support\SslCommerz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /** Send the customer to SSLCommerz for a booking that is not paid yet. */
    public function pay(Booking $booking)
    {
        if ($booking->payment_status === 'paid' || ! in_array($booking->status, ['pending', 'confirmed'], true)) {
            return redirect()->route('booking.show', $booking);
        }

        if (! PaymentGateway::sslcommerz()->isReady()) {
            return redirect()->route('booking.show', $booking)->withErrors(['booking' => 'Online payment is not available right now.']);
        }

        // A new transaction id for every attempt, so a failed try can be repeated.
        $booking->update(['payment_method' => 'sslcommerz', 'transaction_id' => $booking->reference.'-'.Str::upper(Str::random(8))]);

        try {
            return redirect()->away(SslCommerz::make()->start($booking, $booking->transaction_id));
        } catch (\Throwable $exception) {
            Log::warning('SSLCommerz could not start a payment.', ['booking' => $booking->reference, 'error' => $exception->getMessage()]);

            return redirect()->route('booking.show', $booking)->withErrors(['booking' => 'We could not reach the payment page. Please try again.']);
        }
    }

    /** The customer comes back after paying (SSLCommerz posts here). */
    public function success(Request $request)
    {
        $booking = $this->settle($request);
        if (! $booking) {
            return redirect()->route('home');
        }

        $paid = $booking->payment_status === 'paid';

        return redirect()->route('booking.show', $booking)->with(
            $paid ? 'success' : 'error',
            $paid ? 'Payment received. Thank you!' : 'We could not confirm your payment. If money was taken, contact us with your booking reference.'
        );
    }

    /** Server-to-server notice from SSLCommerz. */
    public function ipn(Request $request)
    {
        $this->settle($request);

        return response()->json(['ok' => true]);
    }

    public function fail(Request $request)
    {
        $booking = $this->bookingFor($request);

        return $booking
            ? redirect()->route('booking.show', $booking)->withErrors(['booking' => 'The payment did not go through. You can try again.'])
            : redirect()->route('home');
    }

    public function cancel(Request $request)
    {
        $booking = $this->bookingFor($request);

        return $booking
            ? redirect()->route('booking.show', $booking)->withErrors(['booking' => 'You cancelled the payment. You can pay from this page whenever you are ready.'])
            : redirect()->route('home');
    }

    private function bookingFor(Request $request): ?Booking
    {
        $transaction = $request->input('tran_id');

        return filled($transaction) ? Booking::query()->where('transaction_id', $transaction)->first() : null;
    }

    /** Mark the booking paid only after SSLCommerz itself confirms it. */
    private function settle(Request $request): ?Booking
    {
        $booking = $this->bookingFor($request);
        if (! $booking) {
            return null;
        }
        if ($booking->payment_status === 'paid') {
            return $booking;
        }

        try {
            $paid = SslCommerz::make()->isPaid($booking, $request->input('val_id'));
        } catch (\Throwable $exception) {
            Log::warning('SSLCommerz validation failed.', ['booking' => $booking->reference, 'error' => $exception->getMessage()]);
            $paid = false;
        }

        if ($paid) {
            $booking->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'gateway_reference' => $request->input('bank_tran_id') ?: $request->input('val_id'),
                'status' => $booking->status === 'pending' ? 'confirmed' : $booking->status,
                'confirmed_at' => $booking->confirmed_at ?? now(),
            ]);
        }

        return $booking->fresh();
    }
}
