<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'time_limit'
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function getAverageScore()
    {
        return $this->results()->avg('score');
    }

    public function getTotalParticipants()
    {
        return $this->results()->count();
    }
} 