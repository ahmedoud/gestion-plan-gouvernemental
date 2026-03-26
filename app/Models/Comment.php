<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'programme_id',  // Make sure the programme_id is included here
        'plan_id',
        'user_id',
        'content',
    ];
    // Relation avec Programme
    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
