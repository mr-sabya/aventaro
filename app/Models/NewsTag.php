<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
class NewsTag extends Model { protected $fillable=['name','slug']; protected static function booted(){static::saving(fn($m)=>$m->slug=Str::slug($m->name));} public function posts():BelongsToMany{return $this->belongsToMany(NewsPost::class,'news_post_tag');} public function getRouteKeyName():string{return 'slug';} }
