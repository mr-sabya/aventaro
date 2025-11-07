<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure user is logged in and is admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Optionally redirect non-admin users
        return redirect()->route('admin.login')->with('error', 'Access denied. Admins only.');
    }
}
