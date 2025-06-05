<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Notifications\ReservationExpirationNotification;
use Carbon\Carbon;

class CheckReservations extends Command
{
    protected $signature = 'reservations:check-expiration';
    protected $description = 'Vérifie les réservations qui expirent bientôt';

    public function handle()
    {
        $reservations = Reservation::where('statut', 'active')
            ->where('date_fin', '<=', Carbon::now()->addDay())
            ->where('date_fin', '>', Carbon::now())
            ->with(['client', 'annonce'])
            ->get();

        foreach ($reservations as $reservation) {
            $hoursRemaining = Carbon::now()->diffInHours($reservation->date_fin);
            
            $reservation->client->notify(
                new ReservationExpirationNotification($reservation, $hoursRemaining)
            );
            
            $this->info("Notification envoyée pour la réservation #{$reservation->id}");
        }
    }
}