<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'banner_images',
        'description',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'banner_images' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
