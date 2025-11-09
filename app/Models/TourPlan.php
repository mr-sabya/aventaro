<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tour_id',
        'day_number',
        'title',
        'description'
    ];

    // --------------------------------------------------------------------------
    // Relationships
    // --------------------------------------------------------------------------
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
