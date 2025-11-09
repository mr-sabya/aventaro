<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon_class',
    ];

    /**
     * The tours that have this amenity.
     */
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'amenity_tour');
    }
}
