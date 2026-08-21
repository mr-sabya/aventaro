<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model { protected $fillable=['name','location','quote','image','rating','sort_order','is_active','is_approved']; protected $casts=['is_active'=>'boolean','is_approved'=>'boolean','rating'=>'integer']; }
