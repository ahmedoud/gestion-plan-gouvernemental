<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programme_id'); // Relation avec Programme
            $table->unsignedBigInteger('user_id'); // Relation avec User (auteur du commentaire)
            $table->text('content'); // Contenu du commentaire
            $table->timestamps();

            // Clés étrangères
            $table->foreign('programme_id')->references('id')->on('programmes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
