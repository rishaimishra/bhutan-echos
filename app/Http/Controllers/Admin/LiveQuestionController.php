<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveQuestion;
use App\Models\LiveSession;
use Illuminate\Http\Request;

class LiveQuestionController extends Controller
{
    public function index()
    {
        $questions = LiveQuestion::with(['session', 'user'])->latest()->get();
        return view('admin.live-questions.index', compact('questions'));
    }

    public function create()
    {
        $sessions = LiveSession::where('end_time', '>', now())->get();
        return view('admin.live-questions.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:live_sessions,id',
            'question' => 'required|string',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $validated['user_id'] = auth()->id();
        LiveQuestion::create($validated);

        return redirect()->route('admin.live-questions.index')
            ->with('success', 'Question created successfully.');
    }

    public function edit(LiveQuestion $liveQuestion)
    {
        $sessions = LiveSession::where('end_time', '>', now())->get();
        return view('admin.live-questions.edit', compact('liveQuestion', 'sessions'));
    }

    public function update(Request $request, LiveQuestion $liveQuestion)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:live_sessions,id',
            'question' => 'required|string',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $liveQuestion->update($validated);

        return redirect()->route('admin.live-questions.index')
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(LiveQuestion $liveQuestion)
    {
        $liveQuestion->delete();

        return redirect()->route('admin.live-questions.index')
            ->with('success', 'Question deleted successfully.');
    }
} 