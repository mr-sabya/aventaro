<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class NewsCategory extends Model { protected $fillable=['name','slug','description']; protected static function booted(){static::saving(fn($m)=>$m->slug=Str::slug($m->name));} public function posts():HasMany{return $this->hasMany(NewsPost::class);} public function getRouteKeyName():string{return 'slug';} }
