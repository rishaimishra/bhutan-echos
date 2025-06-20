<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LivePoll;
use App\Models\LiveSession;
use Illuminate\Http\Request;

class LivePollController extends Controller
{
    public function index()
    {
        $polls = LivePoll::with(['session', 'options'])->latest()->get();
        return view('admin.live-polls.index', compact('polls'));
    }

    public function create()
    {
        $sessions = LiveSession::where('end_time', '>', now())->get();
        return view('admin.live-polls.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:live_sessions,id',
            'question' => 'required|string|max:255',
            'multiple_choice' => 'required|boolean',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255'
        ]);

        $poll = LivePoll::create([
            'session_id' => $validated['session_id'],
            'question' => $validated['question'],
            'multiple_choice' => $validated['multiple_choice']
        ]);

        foreach ($validated['options'] as $option) {
            $poll->options()->create(['option' => $option]);
        }

        return redirect()->route('admin.live-polls.index')
            ->with('success', 'Poll created successfully.');
    }

    public function edit(LivePoll $livePoll)
    {
        $sessions = LiveSession::where('end_time', '>', now())->get();
        $livePoll->load('options');
        return view('admin.live-polls.edit', compact('livePoll', 'sessions'));
    }

    public function update(Request $request, LivePoll $livePoll)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:live_sessions,id',
            'question' => 'required|string|max:255',
            'multiple_choice' => 'required|boolean',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255'
        ]);

        $livePoll->update([
            'session_id' => $validated['session_id'],
            'question' => $validated['question'],
            'multiple_choice' => $validated['multiple_choice']
        ]);

        // Delete existing options
        $livePoll->options()->delete();

        // Create new options
        foreach ($validated['options'] as $option) {
            $livePoll->options()->create(['option' => $option]);
        }

        return redirect()->route('admin.live-polls.index')
            ->with('success', 'Poll updated successfully.');
    }

    public function destroy(LivePoll $livePoll)
    {
        $livePoll->delete();

        return redirect()->route('admin.live-polls.index')
            ->with('success', 'Poll deleted successfully.');
    }

    public function results(LivePoll $livePoll)
    {
        $livePoll->load(['options.responses', 'session']);
        return view('admin.live-polls.results', compact('livePoll'));
    }
} 