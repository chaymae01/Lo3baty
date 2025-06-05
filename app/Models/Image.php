<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{    
    use HasFactory;

    protected $fillable = ['url', 'objet_id'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];  
    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }
}