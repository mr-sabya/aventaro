<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function store(Request $request, Tour $tour)
    {
        abort_unless($tour->is_active, 404);

        $validated = $request->validate([
            'travel_date' => ['required', 'date', 'after_or_equal:today'],
            'travellers' => ['required', 'integer', 'min:1', 'max:50'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'payment_method' => ['required', 'in:pay_later,bank_transfer'],
        ]);

        $booking = DB::transaction(function () use ($validated, $tour) {
            $lockedTour = Tour::query()->lockForUpdate()->findOrFail($tour->id);
            $date = $validated['travel_date'];

            if (($lockedTour->available_from && $date < $lockedTour->available_from->format('Y-m-d'))
                || ($lockedTour->available_to && $date > $lockedTour->available_to->format('Y-m-d'))) {
                throw ValidationException::withMessages(['travel_date' => 'This tour is not available on the selected date.']);
            }

            $reserved = Booking::query()->where('tour_id', $lockedTour->id)->whereDate('travel_date', $date)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])->sum('travellers');
            if ($reserved + $validated['travellers'] > $lockedTour->capacity_per_date) {
                throw ValidationException::withMessages(['travellers' => 'Not enough places remain for the selected date.']);
            }

            $subtotal = round((float) $lockedTour->price * $validated['travellers'], 2);
            $coupon = null;
            $discount = 0;
            if (!empty($validated['coupon_code'])) {
                $coupon = Coupon::query()->whereRaw('UPPER(code) = ?', [strtoupper($validated['coupon_code'])])->lockForUpdate()->first();
                if (!$coupon || !$coupon->isAvailable($subtotal)) {
                    throw ValidationException::withMessages(['coupon_code' => 'This coupon is invalid or unavailable.']);
                }
                $discount = $coupon->discountFor($subtotal);
                $coupon->increment('used_count');
            }

            return Booking::create([
                ...$validated,
                'reference' => 'AVT-' . strtoupper(Str::random(10)),
                'cancellation_token' => Str::random(64),
                'tour_id' => $lockedTour->id,
                'coupon_id' => $coupon?->id,
                'coupon_code' => $coupon?->code,
                'unit_price' => $lockedTour->price,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $subtotal - $discount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);
        });

        try {
            Mail::to($booking->email)->send(new BookingConfirmation($booking->load('tour')));
        } catch (\Throwable $exception) {
            Log::warning('Booking confirmation email failed.', ['booking' => $booking->reference, 'error' => $exception->getMessage()]);
        }

        return redirect()->route('booking.show', $booking)->with('success', 'Your booking has been received.');
    }

    public function show(Booking $booking)
    {
        return view('frontend.booking.show', ['booking' => $booking->load('tour.city.country')]);
    }

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate(['token' => ['required', 'string', 'size:64']]);
        abort_unless(hash_equals($booking->cancellation_token, $request->string('token')->toString()), 403);

        if (!in_array($booking->status, ['pending', 'confirmed'], true)) {
            return back()->withErrors(['booking' => 'This booking can no longer be cancelled online.']);
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled', 'cancelled_at' => now()]);
            if ($booking->coupon_id) Coupon::query()->whereKey($booking->coupon_id)->where('used_count', '>', 0)->decrement('used_count');
        });

        return back()->with('success', 'Your booking has been cancelled.');
    }
}
