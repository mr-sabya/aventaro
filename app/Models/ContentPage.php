<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    protected $fillable = ['slug','title','breadcrumb_title','breadcrumb_image','meta_title','meta_description','content','sections','is_active'];
    protected $casts = ['sections'=>'array','is_active'=>'boolean'];
    public function getRouteKeyName(): string { return 'slug'; }
}
