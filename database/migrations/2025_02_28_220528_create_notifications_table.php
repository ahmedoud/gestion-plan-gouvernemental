<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Utilisateur concerné
            $table->string('type'); // Type de notification (task_assigned, comment_added, plan_updated)
            $table->morphs('notifiable'); // Relation polymorphique (plan, task, comment)
            $table->text('message'); // Message de la notification
            $table->boolean('read')->default(false); // Si la notification est lue
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
    
};
