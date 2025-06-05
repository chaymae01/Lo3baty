<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationExpirationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $reservation,
        public $hoursRemaining
    ) {}

    public function via($notifiable)
    {
        return ['mail', 'database']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre réservation se termine bientôt')
            ->line("Votre réservation #{$this->reservation->id} se terminera dans {$this->hoursRemaining} heures.")
            ->action('Voir la réservation', url("/reservations/{$this->reservation->id}"))
            ->line('Merci d\'utiliser notre service!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'reservation_expiration',
            'reservation_id' => $this->reservation->id,
            'message' => "Réservation se termine dans {$this->hoursRemaining}h",
            'url' => "/reservations/{$this->reservation->id}"
        ];
    }
}