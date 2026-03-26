<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'progress',
        'budget',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subActivities()
    {
        return $this->hasMany(SubActivity::class);
    }

    public function calculateProgress()
    {
        $subActivities = $this->subActivities;
        if ($subActivities->count() === 0) {
            return 0;
        }

        $totalProgress = $subActivities->sum('progress');
        return $totalProgress / $subActivities->count();
    }

    public function updateProgress()
    {
        $this->progress = $this->calculateProgress();
        $this->save();
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
