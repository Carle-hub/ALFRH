<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Conge extends Model
{
    use HasFactory;

    protected $fillable = [
        'employe_id',
        'date_debut',
        'date_fin',
        'duree',
        'commentaire',
        'semestre',
        'date_approbation',
        'users_id',
        'solde_conges'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_approbation' => 'datetime',
        'duree' => 'integer',
        'solde_conges' => 'integer',
        'employe_id' => 'integer',
        'users_id' => 'integer'
    ];

    // Relation avec l'employé
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Mutateur pour calculer automatiquement le solde lors de la définition de la durée
    public function setDureeAttribute($value)
    {
        $this->attributes['duree'] = $value;
        // On ne calcule le solde que si semestre ≠ 1
        if (
            (isset($this->attributes['semestre']) && $this->attributes['semestre'] !== 'Semestre 1')
            || !isset($this->attributes['semestre'])
        ) {
            $this->attributes['solde_conges'] = 12 - intval($value);
        }
        // Sinon, on laisse le solde tel quel (null pour Semestre 1)
    }

    // Accesseur pour s'assurer que les dates sont bien formatées
    public function getDateDebutAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getDateFinAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getDateApprobationAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }
}