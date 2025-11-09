<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tour_id',
        'user_id',
        'name',
        'email', // ADDED
        'phone', // ADDED
        'location',
        'image',
        'rating',
        'comment',
        'is_approved',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the tour that this review belongs to.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the user who wrote the review (will be null if it was a guest).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
