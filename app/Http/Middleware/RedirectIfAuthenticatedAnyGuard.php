<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedAnyGuard
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('stats'); // redirect if any auth is logged in
        }
        elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request); // allow access otherwise
    }
}
