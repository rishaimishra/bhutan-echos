<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveQuiz;
use App\Models\LiveSession;
use Illuminate\Http\Request;

class LiveQuizController extends Controller
{
    public function index()
    {
        $quizzes = LiveQuiz::with('liveSession')->latest()->paginate(20);
        return view('admin.live-quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $liveSessions = LiveSession::all();
        return view('admin.live-quizzes.create', compact('liveSessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'live_session_id' => 'required|exists:live_sessions,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        LiveQuiz::create($validated);

        return redirect()->route('admin.live-quizzes.index')
            ->with('success', 'Live quiz created successfully.');
    }

    public function show(LiveQuiz $liveQuiz)
    {
        $liveQuiz->load('liveSession');
        return view('admin.live-quizzes.show', compact('liveQuiz'));
    }

    public function edit(LiveQuiz $liveQuiz)
    {
        $liveSessions = LiveSession::all();
        return view('admin.live-quizzes.edit', compact('liveQuiz', 'liveSessions'));
    }

    public function update(Request $request, LiveQuiz $liveQuiz)
    {
        $validated = $request->validate([
            'live_session_id' => 'required|exists:live_sessions,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        $liveQuiz->update($validated);

        return redirect()->route('admin.live-quizzes.index')
            ->with('success', 'Live quiz updated successfully.');
    }

    public function destroy(LiveQuiz $liveQuiz)
    {
        $liveQuiz->delete();

        return redirect()->route('admin.live-quizzes.index')
            ->with('success', 'Live quiz deleted successfully.');
    }
}
