<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioClip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'audio_url',
        'release_date'
    ];

    protected $casts = [
        'release_date' => 'datetime'
    ];
} 