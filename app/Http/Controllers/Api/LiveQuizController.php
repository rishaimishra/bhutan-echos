<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveQuiz;
use App\Models\LiveQuizResponse;
use Illuminate\Http\Request;

class LiveQuizController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $quizzes = LiveQuiz::with(['questions.answers'])->latest()->get();
        $quizzes = $quizzes->map(function ($quiz) use ($user) {
            if ($user) {
                $right = LiveQuizResponse::where('live_quiz_id', $quiz->id)
                    ->where('user_id', $user->id)
                    ->where('is_correct', true)
                    ->count();
                $wrong = LiveQuizResponse::where('live_quiz_id', $quiz->id)
                    ->where('user_id', $user->id)
                    ->where('is_correct', false)
                    ->count();
                $quiz->user_right = $right;
                $quiz->user_wrong = $wrong;
            } else {
                $quiz->user_right = null;
                $quiz->user_wrong = null;
            }
            return $quiz;
        });
        return response()->json(['live_quizzes' => $quizzes]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $quiz = LiveQuiz::with(['questions.answers'])->findOrFail($id);
        if ($user) {
            $right = LiveQuizResponse::where('live_quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->where('is_correct', true)
                ->count();
            $wrong = LiveQuizResponse::where('live_quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->where('is_correct', false)
                ->count();
            $quiz->user_right = $right;
            $quiz->user_wrong = $wrong;
        } else {
            $quiz->user_right = null;
            $quiz->user_wrong = null;
        }
        return response()->json(['live_quiz' => $quiz]);
    }

    public function submitAnswer(Request $request, $quizId, $questionId)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'selected_answer_id' => 'required|exists:live_quiz_answers,id',
        ]);

        $quiz = \App\Models\LiveQuiz::findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($questionId);
        $answer = $question->answers()->findOrFail($request->selected_answer_id);

        $isCorrect = $answer->is_correct;

        // Store or update the response
        $response = \App\Models\LiveQuizResponse::updateOrCreate(
            [
                'user_id' => $user->id,
                'live_quiz_id' => $quiz->id,
                'live_quiz_question_id' => $question->id,
            ],
            [
                'selected_answer_id' => $answer->id,
                'is_correct' => $isCorrect,
            ]
        );

        // Updated totals
        $right = \App\Models\LiveQuizResponse::where('live_quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('is_correct', true)
            ->count();
        $wrong = \App\Models\LiveQuizResponse::where('live_quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('is_correct', false)
            ->count();

        return response()->json([
            'message' => 'Answer submitted.',
            'is_correct' => $isCorrect,
            'user_right' => $right,
            'user_wrong' => $wrong,
        ]);
    }

    public function myAnswers(Request $request, $quizId)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $quiz = \App\Models\LiveQuiz::with(['questions.answers'])->findOrFail($quizId);
        $responses = \App\Models\LiveQuizResponse::where('live_quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->get()
            ->keyBy('live_quiz_question_id');

        $result = $quiz->questions->map(function ($question) use ($responses) {
            $response = $responses->get($question->id);
            return [
                'question_id' => $question->id,
                'question' => $question->question,
                'answers' => $question->answers->map(function ($a) {
                    return [
                        'id' => $a->id,
                        'answer' => $a->answer,
                        'is_correct' => $a->is_correct,
                    ];
                }),
                'selected_answer_id' => $response ? $response->selected_answer_id : null,
                'selected_answer' => $response && $response->selectedAnswer ? $response->selectedAnswer->answer : null,
                'is_correct' => $response ? $response->is_correct : null,
            ];
        });

        return response()->json([
            'quiz_id' => $quiz->id,
            'quiz_title' => $quiz->title,
            'user_answers' => $result,
        ]);
    }
} 