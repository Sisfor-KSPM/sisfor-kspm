<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AnalyticsService;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track page view untuk user yang terautentikasi
        if (auth()->check() && $request->isMethod('get')) {
            $pageName = $request->route()?->getName() ?? $request->getPathInfo();
            AnalyticsService::trackPageView($pageName);
        }

        return $response;
    }
}
