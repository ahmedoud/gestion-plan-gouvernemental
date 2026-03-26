<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTables extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->bigInteger('permission_id')->unsigned();
            $table->string('model_type');
            $table->bigInteger('model_id')->unsigned();
            $table->primary(['permission_id', 'model_type', 'model_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->string('model_type');
            $table->bigInteger('model_id')->unsigned();
            $table->primary(['role_id', 'model_type', 'model_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->bigInteger('permission_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->primary(['permission_id', 'role_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
}
