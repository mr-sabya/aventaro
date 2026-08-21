<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h4>Bookings</h4></div>
        <div class="card-body">
            @if(session('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif
            <div class="row g-3 mb-4">
                <div class="col-md-8"><input class="form-control" wire:model.live.debounce.300ms="search" placeholder="Reference, customer, email, or tour"></div>
                <div class="col-md-4"><select class="form-select" wire:model.live="status"><option value="all">All statuses</option>@foreach(['pending','confirmed','completed','cancelled','refunded'] as $item)<option value="{{ $item }}">{{ ucfirst($item) }}</option>@endforeach</select></div>
            </div>
            <div class="table-responsive"><table class="table align-middle">
                <thead><tr><th>Reference</th><th>Tour / Date</th><th>Customer</th><th>Guests</th><th>Total</th><th>Booking Status</th><th>Payment</th></tr></thead>
                <tbody>@forelse($bookings as $booking)
                    <tr wire:key="booking-{{ $booking->id }}">
                        <td><a href="{{ route('admin.bookings.show',$booking) }}"><strong>{{ $booking->reference }}</strong></a><br><small>{{ $booking->created_at->format('M j, Y') }}</small></td>
                        <td>{{ $booking->tour?->title }}<br><small>{{ $booking->travel_date->format('M j, Y') }}</small></td>
                        <td>{{ $booking->name }}<br><small>{{ $booking->email }}<br>{{ $booking->phone }}</small></td>
                        <td>{{ $booking->travellers }}</td><td>${{ number_format((float)$booking->total,2) }}</td>
                        <td><select class="form-select form-select-sm" wire:change="setStatus({{ $booking->id }}, $event.target.value)">@foreach(['pending','confirmed','completed','cancelled','refunded'] as $item)<option value="{{ $item }}" @selected($booking->status===$item)>{{ ucfirst($item) }}</option>@endforeach</select></td>
                        <td><select class="form-select form-select-sm" wire:change="setPaymentStatus({{ $booking->id }}, $event.target.value)">@foreach(['unpaid','paid','refunded'] as $item)<option value="{{ $item }}" @selected($booking->payment_status===$item)>{{ ucfirst($item) }}</option>@endforeach</select><small>{{ str($booking->payment_method)->replace('_',' ')->title() }}</small></td>
                    </tr>
                @empty<tr><td colspan="7" class="text-center py-4">No bookings found.</td></tr>@endforelse</tbody>
            </table></div>
            {{ $bookings->links() }}
        </div>
    </div>
</div>
