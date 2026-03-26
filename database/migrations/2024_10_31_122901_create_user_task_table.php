<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTaskTable extends Migration
{
    public function up()
    {
        Schema::create('user_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_task');
    }
}
