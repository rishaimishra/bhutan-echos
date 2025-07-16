<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveQuestion;
use Illuminate\Http\Request;

class LiveQuestionController extends Controller
{
    // List all live questions (optionally filter by session)
    public function index(Request $request)
    {
        $query = LiveQuestion::with(['session', 'user']);
        if ($request->has('session_id')) {
            $query->where('session_id', $request->session_id);
        }
        $questions = $query->latest()->get();
        return response()->json(['live_questions' => $questions]);
    }

    // Allow authenticated users to add a question
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $validated = $request->validate([
            'session_id' => 'required|exists:live_sessions,id',
            'question' => 'required|string',
        ]);
        $question = LiveQuestion::create([
            'session_id' => $validated['session_id'],
            'user_id' => $user->id,
            'question' => $validated['question'],
            'status' => 'pending',
        ]);
        return response()->json(['message' => 'Question submitted successfully.', 'live_question' => $question], 201);
    }
} 