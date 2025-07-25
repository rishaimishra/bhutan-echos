<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'media_type',
        'media_url',
        'decade',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 