<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'programme_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

     // Relation avec les tâches via les sous-activités
    public function tasks()
    {
        return $this->hasManyThrough(
             Task::class,        // Le modèle cible
             Activity::class,    // Le modèle intermédiaire
             'plan_id',          // La clé étrangère dans la table Activities
             'sub_activity_id',  // La clé étrangère dans la table Tasks
             'id',               // Clé primaire de Plan
             'id'                // Clé primaire de Activity
        );
    }

    // Ajouter la relation avec Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Ensure that when creating a comment, the programme_id is included
    public function addComment($content, $userId)
    {
        return $this->comments()->create([
            'content' => $content,
            'user_id' => $userId,
            'programme_id' => $this->programme_id, // Ensure this is set
        ]);
    }
}
