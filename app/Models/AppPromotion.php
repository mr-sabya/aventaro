<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AppPromotion extends Model { protected $fillable=['subtitle','title','description','background_image','app_image','play_store_url','app_store_url','is_active']; protected $casts=['is_active'=>'boolean']; }
