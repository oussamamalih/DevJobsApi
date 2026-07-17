<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Entreprise;
use App\Models\Candidature;
use App\Models\Competence;


class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'title',
        'description',
        'contract_type',
    ];

    public function entreprise()
{
    return $this->belongsTo(Entreprise::class);
}


public function candidatures()
{
    return $this->hasMany(Candidature::class);
}


public function competences()
{
    return $this->belongsToMany(Competence::class);
}
}
