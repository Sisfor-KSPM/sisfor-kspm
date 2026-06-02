<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsGuest
{
    /**
     * Handle an incoming request.
     * Ensure user is NOT authenticated (for login/register pages)
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Redirect to dashboard based on role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
