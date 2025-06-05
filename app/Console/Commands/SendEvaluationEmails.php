<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluationMail;
use Carbon\Carbon;

class SendEvaluationEmails extends Command
{
    protected $signature = 'send:evaluation-emails';
    protected $description = 'Send evaluation emails to users after reservation ends';

    public function handle()
    {
        $today = Carbon::today();
        $now = Carbon::now();
    
        $this->info("Starting process at {$now->toDateTimeString()}");
        $reservations = Reservation::whereDate('date_fin', $today) 
        ->where('is_email', 0) 
        ->where('statut', 'confirmée') 
        ->with(['client:id,email', 'objet'])
        ->get();

    $this->info("Found {$reservations->count()} eligible reservations");

    $sentCount = 0;

    foreach ($reservations as $reservation) {
        try {

            if (!$reservation->relationLoaded('client') || !$reservation->client) {
                $this->error("No user found for reservation ID: {$reservation->id}");
                continue;
            }

            $userEmail = $reservation->client->email;
            
            if (empty($userEmail)) {
                $this->error("Empty email for reservation ID: {$reservation->id}");
                continue;
            }

            $dateFin = Carbon::parse($reservation->date_fin);
            if (!$dateFin->isSameDay($today)) {
                $this->error("Date mismatch for reservation ID: {$reservation->id} ({$dateFin})");
                continue;
            }

            Mail::to($userEmail)->send(new EvaluationMail($reservation));
            
            Reservation::withoutTimestamps(function () use ($reservation) {
                $reservation->update([
                    'is_email' => 1
                ]);
            });

            $sentCount++;
            $this->info("Successfully sent to: {$userEmail}");

        } catch (\Exception $e) {
            $this->error("Failed reservation ID {$reservation->id}: " . $e->getMessage());
        }
    }

    $this->info("Successfully sent {$sentCount}/{$reservations->count()} emails.");
}
}
