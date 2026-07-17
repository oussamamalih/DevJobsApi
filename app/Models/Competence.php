<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Offre;

class Competence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function offres()
{
    return $this->belongsToMany(Offre::class);
}
}
