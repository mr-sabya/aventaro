<?php

namespace App\Livewire\Backend\Booking;

use App\Models\Booking;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public string $search = '';
    public string $status = 'all';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }

    public function setStatus(int $id, string $status): void
    {
        abort_unless(in_array($status, ['pending','confirmed','completed','cancelled','refunded'], true), 422);
        DB::transaction(function () use ($id, $status) {
            $booking = Booking::query()->lockForUpdate()->findOrFail($id);
            $oldStatus = $booking->status;
            $timestamps = ['confirmed_at'=>null,'cancelled_at'=>null,'completed_at'=>null,'refunded_at'=>null];
            if ($status !== 'pending') $timestamps[$status . '_at'] = now();
            $booking->update(['status' => $status] + $timestamps);
            if ($booking->coupon_id && !in_array($oldStatus, ['cancelled','refunded']) && in_array($status, ['cancelled','refunded'])) {
                Coupon::query()->whereKey($booking->coupon_id)->where('used_count','>',0)->decrement('used_count');
            }
            if ($booking->coupon_id && in_array($oldStatus, ['cancelled','refunded']) && !in_array($status, ['cancelled','refunded'])) {
                Coupon::query()->whereKey($booking->coupon_id)->increment('used_count');
            }
        });
        session()->flash('message', 'Booking status updated.');
    }

    public function setPaymentStatus(int $id, string $status): void
    {
        abort_unless(in_array($status, ['unpaid','paid','refunded'], true), 422);
        Booking::findOrFail($id)->update(['payment_status' => $status]);
        session()->flash('message', 'Payment status updated.');
    }

    public function render()
    {
        $bookings = Booking::query()->with('tour')
            ->when($this->status !== 'all', fn($q) => $q->where('status',$this->status))
            ->when($this->search, fn($q) => $q->where(fn($inner) => $inner->where('reference','like',"%{$this->search}%")->orWhere('name','like',"%{$this->search}%")->orWhere('email','like',"%{$this->search}%")->orWhereHas('tour',fn($tour)=>$tour->where('title','like',"%{$this->search}%"))))
            ->latest()->paginate(15);
        return view('livewire.backend.booking.index', compact('bookings'));
    }
}
