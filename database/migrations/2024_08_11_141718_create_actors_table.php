<?php

// database/migrations/xxxx_xx_xx_create_actors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActorsTable extends Migration
{
    public function up()
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actors');
    }
}

