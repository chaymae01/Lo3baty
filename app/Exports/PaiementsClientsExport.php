<?php

namespace App\Exports;

use App\Models\Admin\PaiementsClients;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaiementsClientsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return PaiementsClients::with(['client', 'reservation'])
            ->filter($this->filters)
            ->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Client',
            'Email',
            'Réservation ID',
            'Date Réservation',
            'Montant (€)',
            'Méthode',
            'Statut',
            'Date Paiement'
        ];
    }
    public function map($paiement): array
    {
        return [
            $paiement->id,
            $paiement->client->surnom ?? $paiement->client->email,
            $paiement->client->email,
            $paiement->reservation_id,
            optional($paiement->reservation)->date_debut 
                ? $this->formatDate($paiement->reservation->date_debut)
                : '-',
            number_format($paiement->montant, 2, '.', ''),
            $paiement->methode,
            $paiement->etat,
            $this->formatDate($paiement->date_paiement)
        ];
    }
    
    protected function formatDate($date)
    {
        if (!$date) {
            return '-';
        }
        
        if ($date instanceof \DateTime) {
            return $date->format('d/m/Y H:i');
        }
        
        return \Carbon\Carbon::parse($date)->format('d/m/Y H:i');
    }
}