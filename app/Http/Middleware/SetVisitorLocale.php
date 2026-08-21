<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetVisitorLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('language');
        if ($locale && Language::query()->where('code', $locale)->where('is_active', true)->exists()) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
