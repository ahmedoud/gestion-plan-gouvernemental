<?php

// app/Models/Secteur.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    public function programmes()
    {
        return $this->hasMany(Programme::class); // Assurez-vous que la clé étrangère est correcte
    }

}
