<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveQuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_quiz_question_id',
        'answer',
        'is_correct',
        'order',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(LiveQuizQuestion::class, 'live_quiz_question_id');
    }
}
