<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'bio',
        'start_time',
        'end_time',
        'is_active',
    ];

    public function questions()
    {
        return $this->hasMany(AuthorQuestion::class, 'session_id');
    }
} 