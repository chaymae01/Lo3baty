<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'titre',
        'contenu_email',
        'envoyee',
        'lue',
        'utilisateur_id',
        'annonce_id',
        'reservation_id'
    ];

    protected $casts = [
        'date_creation' => 'datetime'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}