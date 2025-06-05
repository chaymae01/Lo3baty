<?php

namespace App\Observers;

use App\Models\Annonce;
use App\Models\Utilisateur;
use App\Notifications\NouvelleAnnonceNotification;

class AnnonceObserver
{
    public function created(Annonce $annonce)
    {
        $clients = \App\Models\Utilisateur::where('role', 'client')->get();
        
        foreach ($clients as $client) {
            $client->notify(new \App\Notifications\NouvelleAnnonceNotification($annonce));
        }
    }
}