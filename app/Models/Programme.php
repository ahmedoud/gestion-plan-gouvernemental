<?php

// app/Models/Programme.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'secteur_id', // Assurez-vous que cette colonne est définie comme clé étrangère
        'start_date',
        'end_date',
        'status',
        'secteur_id', // Assurez-vous que cette colonne existe dans la table programmes
    ];

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}

}
