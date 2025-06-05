<?php

namespace App\Observers;

use App\Models\Reclamation;
use App\Notifications\ReclamationRepondueNotification;

class ReclamationObserver
{
    public function updated(Reclamation $reclamation)
    {
        if ($reclamation->isDirty('reponse') && !empty($reclamation->reponse)) {
            $reclamation->utilisateur->notify(new ReclamationRepondueNotification($reclamation));
        }
    }
}