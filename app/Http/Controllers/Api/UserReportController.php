<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserReport;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    // Store a new user report
    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'reported_id' => 'required|exists:users,id',
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        if ($user->id == $validated['reported_id']) {
            return response()->json(['message' => 'You cannot report yourself.'], 422);
        }

        $report = UserReport::create([
            'reporter_id' => $user->id,
            'reported_id' => $validated['reported_id'],
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? null,
        ]);

        return response()->json([
            'message' => 'User reported successfully.',
            'report' => $report
        ], 201);
    }
}
