<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'thumbnail',
        'youtube_link',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function liveQuizzes()
    {
        return $this->hasMany(LiveQuiz::class);
    }
}
