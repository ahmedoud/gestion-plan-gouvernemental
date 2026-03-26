<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'progress', // Assurez-vous que ce champ est bien défini
        'budget',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];


    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function calculateProgress()
    {
        $tasks = $this->tasks;
        if ($tasks->count() === 0) {
            return 0;
        }

        $totalProgress = $tasks->sum('progress');
        return $totalProgress / $tasks->count();
    }

    public function updateProgress()
    {
        $this->progress = $this->calculateProgress();
        $this->save();
    }
}
