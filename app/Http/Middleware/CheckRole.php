<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Skip role check if admin is logged in
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        if ($user->role !== $role) {
            return redirect()->route('login')->with('error', 'Action non autorisée pour votre rôle.');
        }

        return $next($request);
    }

}