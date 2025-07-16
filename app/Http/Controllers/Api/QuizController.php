<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    // List all quizzes
    public function index()
    {
        $quizzes = Quiz::withCount(['questions', 'results'])
            ->withAvg('results', 'score')
            ->latest()
            ->get();
        return response()->json(['quizzes' => $quizzes]);
    }

    // Show quiz details with questions
    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return response()->json(['quiz' => $quiz]);
    }

    // Create a new quiz (auth required)
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_limit' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string'
        ]);
        $quiz = DB::transaction(function () use ($validated) {
            $quiz = Quiz::create([
                'title' => $validated['title'],
                'time_limit' => $validated['time_limit'] ?? null
            ]);
            foreach ($validated['questions'] as $question) {
                $quiz->questions()->create([
                    'question' => $question['question'],
                    'options' => $question['options'],
                    'correct_answer' => $question['correct_answer']
                ]);
            }
            return $quiz;
        });
        return response()->json(['message' => 'Quiz created successfully.', 'quiz' => $quiz->load('questions')], 201);
    }

    // Update a quiz (auth required)
    public function update(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $quiz = Quiz::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_limit' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string'
        ]);
        DB::transaction(function () use ($quiz, $validated) {
            $quiz->update([
                'title' => $validated['title'],
                'time_limit' => $validated['time_limit'] ?? null
            ]);
            $quiz->questions()->delete();
            foreach ($validated['questions'] as $question) {
                $quiz->questions()->create([
                    'question' => $question['question'],
                    'options' => $question['options'],
                    'correct_answer' => $question['correct_answer']
                ]);
            }
        });
        return response()->json(['message' => 'Quiz updated successfully.', 'quiz' => $quiz->load('questions')]);
    }

    // Delete a quiz (auth required)
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully.']);
    }

    // Submit answers for a quiz (auth required)
    public function submitAnswers(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $quiz = Quiz::with('questions')->findOrFail($id);
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:quiz_questions,id',
            'answers.*.selected_answer' => 'required|string',
        ]);
        $answers = collect($validated['answers']);
        $score = 0;
        $details = [];
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers->firstWhere('question_id', $question->id);
            $isCorrect = $userAnswer && $userAnswer['selected_answer'] == $question->correct_answer;
            if ($isCorrect) {
                $score++;
            }
            $details[] = [
                'question_id' => $question->id,
                'question' => $question->question,
                'selected_answer' => $userAnswer['selected_answer'] ?? null,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
            ];
        }
        // Store or update result
        \App\Models\QuizResult::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'user_id' => $user->id,
            ],
            [
                'score' => $score
            ]
        );
        return response()->json([
            'message' => 'Quiz submitted.',
            'score' => $score,
            'total' => $quiz->questions->count(),
            'details' => $details
        ]);
    }

    // Get the authenticated user's result for a quiz
    public function myResult(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $quiz = Quiz::with('questions')->findOrFail($id);
        $result = \App\Models\QuizResult::where('quiz_id', $quiz->id)->where('user_id', $user->id)->first();
        if (!$result) {
            return response()->json(['message' => 'No result found for this quiz.'], 404);
        }
        return response()->json([
            'quiz_id' => $quiz->id,
            'quiz_title' => $quiz->title,
            'score' => $result->score,
            'total' => $quiz->questions->count(),
        ]);
    }
} 