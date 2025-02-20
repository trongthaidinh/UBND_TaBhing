<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AccessStatistic;
use Illuminate\Http\Request;

class TrackWebsiteVisits
{
    public function handle(Request $request, Closure $next)
    {
        // Only track page visits for web routes, not admin or API
        if (!$request->is('admin/*') && !$request->is('api/*')) {
            // Increment visits
            AccessStatistic::incrementVisits();
        }
        
        return $next($request);
    }
}