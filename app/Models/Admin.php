<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
   
    use HasFactory, Notifiable;
    protected $table = 'admin';

    protected $fillable = ['nom', 'prenom', 'email', 'mot_pass'];

    protected $hidden = [
        'mot_pass',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->mot_pass;
    }

    public function setMotPassAttribute($value)
    {
        $this->attributes['mot_pass'] = Hash::make($value);
    }
}