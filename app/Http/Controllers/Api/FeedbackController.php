<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\LiveSession;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // List all feedback (optionally filter by session)
    public function index(Request $request)
    {
        $query = Feedback::with(['session', 'user']);
        if ($request->has('session_id')) {
            $query->where('session_id', $request->session_id);
        }
        $feedback = $query->latest()->get();
        return response()->json(['feedback' => $feedback]);
    }

    // Submit feedback (auth required)
    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'session_id' => 'required|exists:live_sessions,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $feedback = Feedback::create([
            'session_id' => $validated['session_id'],
            'user_id' => $user->id,
            'rating' => $validated['rating'] ?? null,
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json(['message' => 'Feedback submitted successfully.', 'feedback' => $feedback], 201);
    }

    // Get feedback for a specific session
    public function sessionFeedback($sessionId)
    {
        $feedback = Feedback::with('user')->where('session_id', $sessionId)->latest()->get();
        return response()->json(['feedback' => $feedback]);
    }
} 