<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_id',
        'currency_id',
        'name',
        'slug',
        'image',
        'description',
        'visa_requirements',
        'area',
        'map_embed_url',
        'features',
        'is_trending',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_trending' => 'boolean',
        'is_active'   => 'boolean',
        'features'    => 'array', // Automatically handles JSON to/from array conversion
    ];

    /**
     * Boot the model to automatically create a slug from the name when creating a new destination.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the city that the destination belongs to. (One-to-Many Inverse)
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the currency used in the destination. (One-to-Many Inverse)
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the country for the destination through its city. (Has-One-Through)
     */
    public function country(): HasOneThrough
    {
        return $this->hasOneThrough(Country::class, City::class, 'id', 'id', 'city_id', 'country_id');
    }

    /**
     * Get all of the FAQs for the destination. (One-to-Many)
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(DestinationFaq::class);
    }

    /**
     * The languages that are spoken in the destination. (Many-to-Many)
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'destination_language');
    }

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    /**
     * Get the route key for the model.
     * Enables route model binding using the 'slug' column instead of the 'id'.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}