<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AnalyticsController;

class TrackAnalytics
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Track page views only for certain routes
        $routeName = $request->route()?->getName() ?? '';
        $pagesToTrack = [
            'home' => 'home',
            'about' => 'about',
            'events' => 'events',
            'gallery' => 'gallery',
            'elibrary' => 'elibrary',
            'kamus' => 'kamus',
            'contact' => 'contact',
            'user.dashboard' => 'user_dashboard',
            'user.event' => 'user_event',
            'user.kalkulator' => 'user_kalkulator',
            'user.kamus' => 'user_kamus',
        ];

        if (in_array($routeName, array_keys($pagesToTrack))) {
            AnalyticsController::logActivity($pagesToTrack[$routeName]);
        }

        return $response;
    }
}
