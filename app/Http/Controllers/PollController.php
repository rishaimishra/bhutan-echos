<?php

namespace App\Http\Controllers;

use App\Models\LivePoll;
use App\Models\PollResponse;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function show(LivePoll $livePoll)
    {
        $livePoll->load(['options', 'session']);
        return view('polls.show', compact('livePoll'));
    }

    public function vote(Request $request, LivePoll $livePoll)
    {
        $validated = $request->validate([
            'option_id' => 'required|exists:poll_options,id'
        ]);

        // Check if user has already voted
        if (!$livePoll->multiple_choice) {
            $existingVote = PollResponse::where('poll_id', $livePoll->id)
                ->where('user_id', auth()->id())
                ->first();

            if ($existingVote) {
                return back()->with('error', 'You have already voted in this poll.');
            }
        }

        // Create the response
        PollResponse::create([
            'poll_id' => $livePoll->id,
            'user_id' => auth()->id(),
            'option_id' => $validated['option_id']
        ]);

        return back()->with('success', 'Your vote has been recorded.');
    }
} 