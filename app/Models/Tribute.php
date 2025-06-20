<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'media_path',
        'description',
        'approved'
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 