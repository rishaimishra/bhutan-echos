<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LivePoll;
use App\Models\PollOption;
use App\Models\PollResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivePollController extends Controller
{
    // List all live polls (optionally filter by session)
    public function index(Request $request)
    {
        $query = LivePoll::with(['options', 'session']);
        if ($request->has('session_id')) {
            $query->where('session_id', $request->session_id);
        }
        $polls = $query->latest()->get();
        return response()->json(['live_polls' => $polls]);
    }

    // Show a single poll with options
    public function show($id)
    {
        $poll = LivePoll::with(['options', 'session'])->findOrFail($id);
        return response()->json(['live_poll' => $poll]);
    }

    // Submit a vote (auth required)
    public function vote(Request $request, $id)
    {
        $user = $request->user();
        $poll = LivePoll::with('options')->findOrFail($id);
        $validated = $request->validate([
            'option_id' => 'required|exists:poll_options,id',
        ]);

        // Check if user has already voted (if not multiple_choice)
        if (!$poll->multiple_choice) {
            $existingVote = PollResponse::where('poll_id', $poll->id)
                ->where('user_id', $user->id)
                ->first();
            if ($existingVote) {
                return response()->json(['message' => 'You have already voted in this poll.'], 409);
            }
        }

        // Create the response
        $response = PollResponse::create([
            'poll_id' => $poll->id,
            'user_id' => $user->id,
            'option_id' => $validated['option_id'],
        ]);

        return response()->json(['message' => 'Your vote has been recorded.']);
    }

    // Show poll results (option counts)
    public function results($id)
    {
        $poll = LivePoll::with(['options.responses'])->findOrFail($id);
        $results = $poll->options->map(function ($option) {
            return [
                'option_id' => $option->id,
                'option' => $option->option,
                'votes' => $option->responses->count(),
            ];
        });
        return response()->json([
            'poll_id' => $poll->id,
            'question' => $poll->question,
            'results' => $results,
        ]);
    }
} 