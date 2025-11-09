<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'name', 'slug', 'is_active'];

    /**
     * Boot the model to automatically create a slug.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($city) => $city->slug = Str::slug($city->name));
    }

    /**
     * Get the country that the city belongs to.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get all of the destinations for the City.
     */
    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }

    /**
     * Use the 'slug' for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
