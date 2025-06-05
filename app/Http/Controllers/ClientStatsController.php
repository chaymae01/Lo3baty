<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Reclamation;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class ClientStatsController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // Get client info
        $client = Utilisateur::find($user->id);

        $totalClients = Utilisateur::where('role', 'client')->count();
        $totalReservations = Reservation::where('client_id', $user->id)->count();
        $totalReclamations = Reclamation::where('utilisateur_id', $user->id)->count();

        $startDate = $client->created_at->format('d/m/Y');

        // Calculate average note
        $averageNote = DB::table('evaluation_on_clients')
            ->where('client_id', $user->id)
            ->avg('note');

        $averageNote = $averageNote ? round($averageNote, 2) : 'Aucune';

        return view('client.stats', [
            'clientName' => $client->nom,
            'clientPrenom' => $client->prenom,
            'totalClients' => $totalClients,
            'totalReservations' => $totalReservations,
            'totalReclamations' => $totalReclamations,
            'startDate' => $startDate,
            'averageNote' => $averageNote
        ]);
    }
}

