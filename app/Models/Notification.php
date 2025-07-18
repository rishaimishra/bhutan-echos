<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'scheduled_at',
        'sent'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent' => 'boolean'
    ];
} 