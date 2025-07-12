<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_session_id',
        'title',
        'description',
        'is_active',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function liveSession()
    {
        return $this->belongsTo(LiveSession::class);
    }

    public function questions()
    {
        return $this->hasMany(LiveQuizQuestion::class)->orderBy('order');
    }
}
