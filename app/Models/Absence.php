<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'employe_id',
        'type',
        'date_debut',
        'date_retour',
        'duree',
        'justification',
        'date_approbation',
        'users_id',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
