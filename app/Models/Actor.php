<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'role'];

    // Correctly defines the many-to-many relationship with Task
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'actor_task', 'actor_id', 'task_id');
    }
}

