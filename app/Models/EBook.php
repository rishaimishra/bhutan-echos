<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'file_path',
        'format',
    ];

    protected $table = 'ebooks';
} 