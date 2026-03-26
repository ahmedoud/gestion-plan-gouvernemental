<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins'; // Nom de la table

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Si vous utilisez Laravel 7 ou une version plus récente, vous devez également hasher les mots de passe
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
