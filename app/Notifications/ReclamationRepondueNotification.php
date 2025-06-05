<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReclamationRepondueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reclamation;

    public function __construct($reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'reclamation_reponse',
            'reclamation_id' => $this->reclamation->id,
            'message' => 'Réponse à votre réclamation #'.$this->reclamation->id,
            'sujet' => $this->reclamation->sujet,
            'reponse' => $this->reclamation->reponse,
            'url' => route('reclamations.show', $this->reclamation->id)
        ];
    }
}