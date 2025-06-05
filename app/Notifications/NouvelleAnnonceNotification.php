<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NouvelleAnnonceNotification extends Notification
{
    use Queueable;

    protected $annonce;

    public function __construct($annonce)
    {
        $this->annonce = $annonce;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'nouvelle_annonce', 
            'annonce_id' => $this->annonce->id,
            'message' => 'Nouvelle annonce disponible',
            'titre' => $this->annonce->titre,
            'url' => route('annonceID', $this->annonce->id),
            'created_at' => now()->toDateTimeString()
        ];
    }
}