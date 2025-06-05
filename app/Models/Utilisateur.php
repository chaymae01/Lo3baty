<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Utilisateur extends Authenticatable implements MustVerifyEmail
{
  use HasFactory, Notifiable;

  protected $table = 'utilisateurs';
    protected $fillable = [
        'nom', 
        'prenom', 
        'surnom', 
        'email', 
        'mot_de_passe', 
        'role', 
        'is_active',
        'image_profil', 
        'cin_recto', 
        'cin_verso',
        'notification_annonce'
    ];


    protected $hidden = [
        'mot_de_passe',
        'remember_token',
      ];
    protected $casts = [
        'date_inscription' => 'datetime',
        'role' => 'string',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['date_inscription'];
    // Récupérer l'URL de l'image de profil, si elle existe
    public function getImageProfilAttribute($value)
    {
        return $value ? url('storage/' . $value) : url('storage/default-profile.jpg');
    }

    // Relations
    public function objets()
    {
        return $this->hasMany(Objet::class, 'proprietaire_id');
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'proprietaire_id');
    }
  public function paiements()
    {
        return $this->hasMany(PaiementClient::class, 'client_id');
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function evaluationsPartenaire()
    {
    return $this->hasMany(EvaluationOnPartner::class, 'partner_id');
    }

    public function evaluationsClient()
    {
    return $this->hasMany(EvaluationOnPartner::class, 'client_id');
    }

    public function getNoteMoyenneAttribute()
    {
        return $this->evaluationsPartenaire->avg('note') ?? 0;
    }
    
    public function isPartner()
    {
    return $this->role === 'partenaire';
    }

    // Mutator pour le mot de passe
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = Hash::make($value);
    }
    public function getAuthPassword()
    {
      return $this->mot_de_passe;
    }
    // Méthodes pratiques
  public function activate()
  {
    $this->update(['is_active' => true]);
  }

  public function deactivate()
  {
    $this->update(['is_active' => false]);
  }

  public function isActive(): bool
  {
    return $this->is_active;
  }
     public function isAnnonceNotificationActive(): bool
    {
        return $this->notification_annonce === 'active';
    }

    public function toggleAnnonceNotification(bool $active): void
    {
        $this->notification_annonce = $active ? 'active' : 'desactive';
        $this->save();
    }
}