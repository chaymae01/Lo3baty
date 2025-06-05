<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Objet;
use App\Models\Annonce;
use App\Models\EvaluationOnAnnonce;
use App\Models\Reservation;

class AccueilController extends Controller
{
    
    public function index()
    {
        $objet = Objet::with(['images', 'annonces' => function ($query) {
            $query->orderByDesc('premium')
                  ->orderByDesc('date_publication');
        }])
        ->withMax(['annonces as latest_premium_date' => function ($query) {
            $query->where('premium', true);
        }], 'date_publication')
        ->orderByDesc('latest_premium_date')
        ->get();

        $testimonials = EvaluationOnAnnonce::with(['client', 'objet'])
        ->where('note', '>=', 4) 
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();

        return view('client/acceuil', compact('objet', 'testimonials'));

    }

    public function annonces()
    {
    $annonces = Annonce::all(); 
    return view('client/annonces', compact('annonces'));
    }

    public function annonceById($id)
    {
    $annonce = Annonce::with('objet', 'objet.images')->findOrFail($id);
    return view('client.details_annonce', compact('annonce'));
    }
    public function destroy(Request $request)
    {
        //Auth::guard('web')->logout();
    
       // $request->session()->invalidate();
    
       // $request->session()->regenerateToken();
    
        return redirect('/');
    }
    }

