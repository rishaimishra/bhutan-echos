<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'question',
        'status'
    ];

    public function session()
    {
        return $this->belongsTo(LiveSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 