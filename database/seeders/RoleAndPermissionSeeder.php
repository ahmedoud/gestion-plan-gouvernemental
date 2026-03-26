<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Création des permissions (vérification préalable)
        $permissions = [
            'manage users',
            'view plans',
            'create plans',
            'edit plans',
            'delete plans',
            'manage programmes',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Création des rôles et attribution des permissions (vérification préalable)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $responsableRole = Role::firstOrCreate(['name' => 'responsable']);
        $responsableRole->syncPermissions([
            'view plans',
            'create plans',
            'edit plans',
            'manage programmes',
        ]);

        $userRole = Role::firstOrCreate(['name' => 'utilisateur_simple']);
        $userRole->syncPermissions(['view plans']);
    }
}
