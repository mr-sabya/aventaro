<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Payment gateway settings the site owner fills in from the admin. Keys are stored encrypted. */
class PaymentGateway extends Model
{
    public const SSLCOMMERZ = 'sslcommerz';

    protected $fillable = ['provider', 'is_active', 'is_sandbox', 'store_id', 'store_password', 'currency', 'rate'];

    protected $hidden = ['store_id', 'store_password'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_sandbox' => 'boolean',
        'store_id' => 'encrypted',
        'store_password' => 'encrypted',
        'rate' => 'decimal:4',
    ];

    public static function sslcommerz(): self
    {
        return static::firstOrCreate(['provider' => self::SSLCOMMERZ]);
    }

    public function hasKeys(): bool
    {
        return filled($this->store_id) && filled($this->store_password);
    }

    /** Offered to visitors only when switched on and both keys are saved. */
    public function isReady(): bool
    {
        return $this->is_active && $this->hasKeys();
    }
}
