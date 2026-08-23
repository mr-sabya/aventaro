<?php
namespace App\Support;
use Illuminate\Support\Facades\Storage;
class Media { public static function url(?string $path,string $fallback='assets/frontend/img/breadcrumb-bg.jpg'):string {return $path&&Storage::disk('public')->exists($path)?Storage::url($path):asset($fallback);} }
