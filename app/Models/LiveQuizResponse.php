<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveQuizResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'live_quiz_id',
        'live_quiz_question_id',
        'selected_answer_id',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(LiveQuiz::class, 'live_quiz_id');
    }

    public function question()
    {
        return $this->belongsTo(LiveQuizQuestion::class, 'live_quiz_question_id');
    }

    public function selectedAnswer()
    {
        return $this->belongsTo(LiveQuizAnswer::class, 'selected_answer_id');
    }
}
