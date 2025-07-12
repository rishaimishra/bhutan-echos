<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveQuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_quiz_id',
        'question',
        'question_type',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function liveQuiz()
    {
        return $this->belongsTo(LiveQuiz::class);
    }

    public function answers()
    {
        return $this->hasMany(LiveQuizAnswer::class)->orderBy('order');
    }
}
