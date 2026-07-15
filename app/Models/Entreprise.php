<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'sector',
        'description',
        'logo',
    ];


    // Une entreprise appartient à un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Une entreprise possède plusieurs offres
    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}