<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackLastVisitedPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only track for authenticated users
        if (Auth::check()) {
            $currentUrl = $request->fullUrl();
            $currentPath = $request->path();
            
            // List of paths to exclude from tracking
            $excludedPaths = [
                'logout',
                'login',
                'register',
                'password',
                'profile/setup',
                'business/setup',
            ];
            
            // Check if current path should be excluded
            $shouldExclude = false;
            foreach ($excludedPaths as $excluded) {
                if (str_contains($currentPath, $excluded)) {
                    $shouldExclude = true;
                    break;
                }
            }
            
            // Only track GET requests and exclude certain paths
            if ($request->isMethod('get') && !$shouldExclude && !$request->ajax()) {
                session(['last_visited_page' => $currentUrl]);
            }
        }
        
        return $next($request);
    }
}
