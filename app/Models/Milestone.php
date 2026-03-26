<?php

// app/Models/Milestone.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'due_date', 'activity_id'];

    // Définir la relation avec l'activité
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
