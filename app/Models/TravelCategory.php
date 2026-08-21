<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TravelCategory extends Model { protected $fillable=['name','icon_image','tour_count','starting_price','url','sort_order','is_active']; protected $casts=['is_active'=>'boolean','starting_price'=>'decimal:2']; }
