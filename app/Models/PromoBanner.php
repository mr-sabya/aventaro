<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PromoBanner extends Model { protected $fillable=['subtitle','title','button_text','button_url','background_image','is_active']; protected $casts=['is_active'=>'boolean']; }
