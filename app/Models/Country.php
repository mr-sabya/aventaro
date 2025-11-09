<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'is_active'];

    /**
     * Boot the model to automatically create a slug.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($country) => $country->slug = Str::slug($country->name));
    }

    /**
     * Get all of the cities for the Country.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Use the 'slug' for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}