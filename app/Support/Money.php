<?php

namespace App\Support;

use App\Models\Currency;

class Money
{
    public static function format(float|int|string|null $amount): string
    {
        $code = session('currency', 'USD');
        $currency = Currency::query()->where('code', $code)->where('is_active', true)->first()
            ?? Currency::query()->where('is_active', true)->orderBy('id')->first();
        $value = (float) $amount * (float) ($currency?->exchange_rate ?? 1);
        $prefix = $currency?->symbol ?: (($currency?->code ?? 'USD').' ');

        return $prefix.number_format($value, 2);
    }
}
