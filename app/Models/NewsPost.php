<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class NewsPost extends Model
{
    protected $fillable=['news_category_id','title','slug','author','excerpt','content','image','image_alt','published_at','is_active','status','view_count'];
    protected $casts=['published_at'=>'datetime','is_active'=>'boolean','view_count'=>'integer'];
    protected static function booted(){static::saving(function($post){if(!$post->slug||$post->isDirty('title'))$post->slug=Str::slug($post->title);});}
    public function category():BelongsTo{return $this->belongsTo(NewsCategory::class,'news_category_id');}
    public function tags():BelongsToMany{return $this->belongsToMany(NewsTag::class,'news_post_tag');}
    public function scopePublished(Builder $query):Builder{return $query->where('is_active',true)->where('status','published')->whereNotNull('published_at')->where('published_at','<=',now());}
    public function getRouteKeyName():string{return 'slug';}
}
