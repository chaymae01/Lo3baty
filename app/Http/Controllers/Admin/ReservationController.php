<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['client', 'annonce'])
            ->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $reservations = $query->paginate(10);
        $statuts = ['en_attente', 'confirmée', 'refusée'];


        return view('admin.reservations.index', compact('reservations', 'statuts'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['client', 'annonce']);
        return view('admin.reservations.show', compact('reservation'));
    }
}