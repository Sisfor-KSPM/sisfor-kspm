<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    /**
     * Handle an incoming request.
     * Ensure user is authenticated and NOT an admin
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role === 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman user.');
        }

        return $next($request);
    }
}
