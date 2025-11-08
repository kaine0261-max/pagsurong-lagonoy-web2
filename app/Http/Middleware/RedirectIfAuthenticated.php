<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                // Get the last visited page from session
                $lastVisitedPage = session('last_visited_page');
                
                // If there's a last visited page, redirect there
                if ($lastVisitedPage) {
                    return redirect($lastVisitedPage);
                }
                
                // Otherwise, redirect based on user role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'business_owner') {
                    if ($user->businessProfile) {
                        $type = $user->businessProfile->business_type;
                        switch ($type) {
                            case 'hotel':
                                return redirect()->route('business.my-hotel');
                            case 'resort':
                                return redirect()->route('business.my-resort');
                            default:
                                return redirect()->route('business.my-shop');
                        }
                    } else {
                        return redirect()->route('business.setup');
                    }
                } elseif ($user->role === 'customer') {
                    if (!$user->profile) {
                        return redirect()->route('profile.setup');
                    } else {
                        return redirect()->route('customer.products');
                    }
                } else {
                    return redirect()->route('customer.products');
                }
            }
        }

        return $next($request);
    }
}
