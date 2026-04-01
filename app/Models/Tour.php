<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Tour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_id',
        'address',
        'title',
        'slug',
        'description',
        'price',
        'old_price',
        'duration',
        'countries_covered',
        'thumbnail_image',
        'details_image',
        'features',
        'map_embed_url',
        'is_featured',
        'is_hot_deal',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    protected static function boot()
    {
        parent::boot();

        // Handle slug on creation
        static::creating(function ($tour) {
            if (empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });

        // Handle slug on update (if title changes)
        static::updating(function ($tour) {
            $tour->slug = Str::slug($tour->title);
        });
    }

    /**
     * Get the city where the tour is located.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the country for the tour through its city.
     * This is a convenient shortcut to access the country directly.
     */
    public function country(): HasOneThrough
    {
        return $this->hasOneThrough(Country::class, City::class, 'id', 'id', 'city_id', 'country_id');
    }

    /**
     * Get the day-by-day plan for the tour.
     */
    public function plans(): HasMany
    {
        return $this->hasMany(TourPlan::class)->orderBy('day_number');
    }

    /**
     * Get the amenities included in the tour.
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'amenity_tour');
    }

    /**
     * Get the approved customer reviews for the tour.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(TourReview::class)->where('is_approved', true);
    }
}
