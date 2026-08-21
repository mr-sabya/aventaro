<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class TeamMember extends Model
{
    protected $fillable=['name','slug','role','bio','email','phone','experience','image','facebook_url','twitter_url','instagram_url','sort_order','is_active'];
    protected $casts=['is_active'=>'boolean'];
    protected static function booted(){static::saving(function($member){if(!$member->slug||$member->isDirty('name'))$member->slug=Str::slug($member->name);});}
    public function getRouteKeyName():string{return 'slug';}
}
