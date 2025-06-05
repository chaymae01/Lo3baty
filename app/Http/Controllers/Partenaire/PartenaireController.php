<?php


namespace App\Http\Controllers\Partenaire;

use Illuminate\Http\Request;

class PartenaireController extends Controller
{
    public function dashboard()
    {
        return view('partenaire.dashboard');
    }
}
