<?php

namespace App\Exports;

use App\Models\Admin\PaiementsPartenaires;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class PaiementsPartenairesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return PaiementsPartenaires::with(['partenaire', 'annonce'])
            ->filter($this->filters)
            ->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Partenaire',
            'Email',
            'Annonce ID',
            'Prix Journalier (€)',
            'Montant (€)',
            'Période',
            'Méthode',
            'Date Paiement'
        ];
    }

    public function map($paiement): array
    {
        return [
            $paiement->id,
            $paiement->partenaire->surnom,
            $paiement->partenaire->email,
            $paiement->annonce_id,
            optional($paiement->annonce)->prix_journalier ?? '0',
            number_format($paiement->montant, 2, '.', ''),
            $paiement->periode . ' jours',
            $paiement->methode,
            $paiement->date_paiement->format('d/m/Y H:i')
        ];
    }
}