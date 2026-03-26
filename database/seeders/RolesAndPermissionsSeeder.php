<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Désactiver les contraintes de clé étrangère
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Supprimer les données existantes
        \DB::table('role_has_permissions')->truncate();
        \DB::table('model_has_permissions')->truncate();
        \DB::table('model_has_roles')->truncate();
        \DB::table('roles')->truncate();
        \DB::table('permissions')->truncate();

        // Réactiver les contraintes de clé étrangère
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Création des permissions
        $permissions = ['create plans', 'edit plans', 'delete plans', 'view plans'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Création des rôles
        $roles = ['admin', 'plan_manager', 'end_user'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Attribution des permissions aux rôles
        $admin = Role::where('name', 'admin')->first();
        $planManager = Role::where('name', 'plan_manager')->first();
        $user = Role::where('name', 'end_user')->first();

        $admin->syncPermissions(Permission::all());
        $planManager->syncPermissions(['create plans', 'edit plans']);
        $user->syncPermissions(['view plans']);
    }
}
