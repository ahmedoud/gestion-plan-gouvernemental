<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_activity_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'progress',
        'budget',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function subActivity()
    {
        return $this->belongsTo(SubActivity::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_task', 'task_id', 'user_id');
    }

}
