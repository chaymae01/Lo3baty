<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
use App\Models\Reservation;

class EvaluationOnClients extends Model
{
    protected $table = 'evaluation_on_clients';

    protected $fillable = [
        'reservation_id',
        'client_id',
        'partner_id',
        'note',
        'commentaire',
        'is_flagged',
        'flag_reason'
    ];

    protected $casts = [
        'is_flagged' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }

    public function partner()
    {
        return $this->belongsTo(Utilisateur::class, 'partner_id');
    }

   

    public function getTypeAttribute()
    {
        return 'Client → Partenaire';
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}