<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;
    // use \Illuminate\Database\Eloquent\SoftDeletes; // Si vous souhaitez activer la suppression douce (soft delete), décommentez la ligne suivante :

    protected $fillable = [
        'nom',
        'email',
        'poste',
        'departement',
        'adresse',
        'telephone',
    ];

    // Relation avec les congés
    public function conges()
    {
        return $this->hasMany(\App\Models\Conge::class, 'employe_id');
    }

    // Relation avec les absences
    public function absences()
    {
        return $this->hasMany(\App\Models\Absence::class, 'id_employes');
    }
}