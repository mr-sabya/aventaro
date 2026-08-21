<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = ['reference', 'cancellation_token', 'tour_id', 'coupon_id', 'travel_date', 'travellers', 'name', 'email', 'phone', 'address', 'notes', 'unit_price', 'subtotal', 'discount', 'total', 'coupon_code', 'status', 'payment_method', 'payment_status', 'admin_notes', 'confirmed_at', 'cancelled_at', 'completed_at', 'refunded_at'];
    protected $casts = ['travel_date' => 'date', 'unit_price' => 'decimal:2', 'subtotal' => 'decimal:2', 'discount' => 'decimal:2', 'total' => 'decimal:2', 'confirmed_at' => 'datetime', 'cancelled_at' => 'datetime', 'completed_at' => 'datetime', 'refunded_at' => 'datetime'];

    public function tour(): BelongsTo { return $this->belongsTo(Tour::class); }
    public function coupon(): BelongsTo { return $this->belongsTo(Coupon::class); }
    public function getRouteKeyName(): string { return 'reference'; }
}
