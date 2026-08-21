<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() { return view('backend.booking.index'); }
    public function coupons() { return view('backend.booking.coupons'); }
    public function show(Booking $booking) { return view('backend.booking.show', ['booking' => $booking->load(['tour.city.country','coupon'])]); }
    public function updateNotes(Request $request, Booking $booking)
    {
        $booking->update($request->validate(['admin_notes' => ['nullable','string','max:2000']]));
        return back()->with('message', 'Internal notes updated.');
    }
}
