<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class UpdateRolesTable extends Migration
{
    public function up()
    {
        // Mise à jour des rôles en français
        DB::table('roles')->where('name', 'plan_manager')->update(['name' => 'responsable']);
        DB::table('roles')->where('name', 'end_user')->update(['name' => 'utilisateur_simple']);
    }

    public function down()
    {
        // Réversibilité de la migration
        DB::table('roles')->where('name', 'responsable')->update(['name' => 'plan_manager']);
        DB::table('roles')->where('name', 'utilisateur_simple')->update(['name' => 'end_user']);
    }
}
