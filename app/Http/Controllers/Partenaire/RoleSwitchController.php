<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleSwitchController extends Controller
{
    public function switchToClient()
    {
        $user = Auth::user();

        // Update in DB
        $user->role = 'client';
        $user->save();

        // Refresh session
        Auth::setUser($user);

        return redirect()->route('stats'); // or wherever the client dashboard is
    }
}
