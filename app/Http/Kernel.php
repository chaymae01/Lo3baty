<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'role' => \App\Http\Middleware\CheckRole::class,
        'checkUserStatus' => \App\Http\Middleware\CheckUserStatus::class, 
        'guestany' => \App\Http\Middleware\RedirectIfAuthenticatedAnyGuard::class,
    ];
}