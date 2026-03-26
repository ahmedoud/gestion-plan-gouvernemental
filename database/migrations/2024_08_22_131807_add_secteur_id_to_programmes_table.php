<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecteurIdToProgrammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->unsignedBigInteger('secteur_id')->nullable()->after('id');
            $table->foreign('secteur_id')->references('id')->on('secteurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropForeign(['secteur_id']);
            $table->dropColumn('secteur_id');
        });
    }
}
