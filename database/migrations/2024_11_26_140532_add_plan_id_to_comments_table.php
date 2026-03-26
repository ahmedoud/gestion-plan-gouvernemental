<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanIdToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable();  // Ajout de plan_id
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');  // Relation avec la table plans
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);  // Supprimer la clé étrangère
            $table->dropColumn('plan_id');  // Supprimer la colonne plan_id
        });
    }
}
