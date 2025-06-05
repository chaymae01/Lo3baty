<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifiableType = 'App\\Models\\Utilisateur'; 
        $notifiableId = 1; 
        DB::table('notifications')->insert([
            [
                'id' => Str::uuid(),
                'type' => 'App\\Notifications\\NouvelleAnnonceNotification',
                'notifiable_type' => $notifiableType,
                'notifiable_id' => $notifiableId,
                'data' => json_encode([
                    'type' => 'nouvelle_annonce',
                    'annonce_id' => 1,
                    'message' => 'Nouvelle annonce disponible',
                    'titre' => 'Vélo pour enfant',
                    'url' => url('/annonces/1'),
                    'created_at' => now()->toDateTimeString()
                ]),
                'read_at' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'id' => Str::uuid(),
                'type' => 'App\\Notifications\\ReclamationRepondueNotification',
                'notifiable_type' => $notifiableType,
                'notifiable_id' => $notifiableId,
                'data' => json_encode([
                    'type' => 'reclamation_reponse',
                    'reclamation_id' => 1,
                    'message' => 'Réponse à votre réclamation #3',
                    'sujet' => 'Objet non conforme',
                    'reponse' => 'Nous avons vérifié et allons vous rembourser.',
                    'url' => url('/reclamations/1')
                ]),
                'read_at' => null,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'id' => Str::uuid(),
                'type' => 'App\\Notifications\\ReservationExpirationNotification',
                'notifiable_type' => $notifiableType,
                'notifiable_id' => $notifiableId,
                'data' => json_encode([
                    'type' => 'reservation_expiration',
                    'reservation_id' => 2,
                    'message' => 'Réservation se termine dans 5h',
                    'url' => url('/reservations/2')
                ]),
                'read_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
