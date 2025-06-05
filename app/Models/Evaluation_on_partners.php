<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation_on_partners extends Model
{
    use HasFactory;

    protected $table = 'evaluation_on_partners';

    protected $fillable = [
        'reservation_id',
        'partner_id',
        'client_id',
        'note',
        'commentaire'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function partner()
    {
        return $this->belongsTo(Utilisateur::class, 'partner_id');
    }

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }
}