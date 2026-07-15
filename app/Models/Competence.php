<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offre;

class Competence extends Model
{
    public function offres()
{
    return $this->belongsToMany(Offre::class);
}
}
