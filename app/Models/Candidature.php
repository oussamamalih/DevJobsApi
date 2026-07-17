<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Offre;


class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offre_id',
        'status',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}


public function offre()
{
    return $this->belongsTo(Offre::class);
}
}
