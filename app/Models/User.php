<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_task');
    }
// Récupérer les programmes d'un utilisateur via les tâches
public function programmes()
{
    return $this->hasManyThrough(
        Programme::class, // Le programme est lié à la tâche via plusieurs niveaux (tâches -> activités -> plans -> programmes)
        Task::class,
        'user_id', // Clé étrangère dans la table pivot user_task
        'id', // Clé primaire du programme
        'id', // Clé primaire de l'utilisateur
        'plan_id' // Clé étrangère dans la table Task pointant vers Plan
    );
}

    /**
     * Vérifie si l'utilisateur a le rôle "admin".
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Vérifie si l'utilisateur a le rôle "responsable".
     *
     * @return bool
     */
    public function isResponsable()
    {
        return $this->hasRole('responsable');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
