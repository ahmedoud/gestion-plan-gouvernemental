<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteActorsAndAdminsTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('actors');
        Schema::dropIfExists('admins');
    }

    public function down()
    {
        // Si vous voulez pouvoir revenir en arrière, vous pouvez recréer les tables ici
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
