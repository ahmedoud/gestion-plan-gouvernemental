<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasFactory;

    use HasFactory, HasRoles;
    // Indiquez le nom de la table associée si ce n'est pas une convention Laravel par défaut
    protected $table = 'roles';

    // Déclarez les colonnes modifiables
    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id')
                    ->wherePivot('model_type', User::class);
    }

}
