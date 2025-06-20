<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'question',
        'is_approved',
    ];

    public function session()
    {
        return $this->belongsTo(AuthorSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 