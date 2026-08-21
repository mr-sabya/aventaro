<h1>Booking received</h1>
<p>Hello {{ $booking->name }},</p>
<p>We received your booking for <strong>{{ $booking->tour->title }}</strong>.</p>
<p><strong>Reference:</strong> {{ $booking->reference }}<br><strong>Travel date:</strong> {{ $booking->travel_date->format('F j, Y') }}<br><strong>Travellers:</strong> {{ $booking->travellers }}<br><strong>Total:</strong> ${{ number_format((float)$booking->total, 2) }}<br><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
<p><a href="{{ route('booking.show', $booking) }}">View your booking</a></p>
