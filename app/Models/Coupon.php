<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'minimum_total', 'usage_limit', 'used_count', 'starts_at', 'expires_at', 'is_active'];
    protected $casts = ['value' => 'decimal:2', 'minimum_total' => 'decimal:2', 'starts_at' => 'datetime', 'expires_at' => 'datetime', 'is_active' => 'boolean'];

    public function bookings(): HasMany { return $this->hasMany(Booking::class); }

    public function isAvailable(float $subtotal): bool
    {
        return $this->is_active
            && (!$this->starts_at || $this->starts_at->isPast())
            && (!$this->expires_at || $this->expires_at->isFuture())
            && (!$this->usage_limit || $this->used_count < $this->usage_limit)
            && $subtotal >= (float) $this->minimum_total;
    }

    public function discountFor(float $subtotal): float
    {
        $discount = $this->type === 'percent' ? $subtotal * ((float) $this->value / 100) : (float) $this->value;
        return round(min($discount, $subtotal), 2);
    }
}
