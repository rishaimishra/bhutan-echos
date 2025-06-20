<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivePoll extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'question',
        'multiple_choice'
    ];

    protected $casts = [
        'multiple_choice' => 'boolean'
    ];

    public function session()
    {
        return $this->belongsTo(LiveSession::class, 'session_id');
    }

    public function options()
    {
        return $this->hasMany(PollOption::class, 'poll_id');
    }

    public function responses()
    {
        return $this->hasMany(PollResponse::class, 'poll_id');
    }
} 