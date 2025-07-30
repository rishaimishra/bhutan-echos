<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioClip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'media_url',
        'media_type',
        'release_date',
        'description',
    ];

    protected $casts = [
        'release_date' => 'datetime'
    ];
} 