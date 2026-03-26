<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_milestones_table.php
public function up()
{
    Schema::create('milestones', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Titre du jalon
        $table->text('description')->nullable(); // Description
        $table->date('due_date'); // Date de réalisation du jalon
        $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade'); // Relation avec les activités
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('milestones');
    }

};
