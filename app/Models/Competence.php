<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offre;

class Competence extends Model
{
    protected $fillable = [
        'name',
    ];

    public function offres()
{
    return $this->belongsToMany(Offre::class);
}
}
