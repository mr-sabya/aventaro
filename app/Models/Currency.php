<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'symbol'];

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }
}
