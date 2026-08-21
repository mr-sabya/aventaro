<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DestinationFaq extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * We explicitly name it to avoid confusion.
     */
    protected $table = 'destination_faqs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'question',
        'answer',
        'is_active',
    ];

    /**
     * The destinations that this FAQ belongs to.
     */
    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'destination_faq');
    }
}
