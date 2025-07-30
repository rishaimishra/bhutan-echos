<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use Illuminate\Http\Request;
use App\Models\Feedback;

class LiveSessionController extends Controller
{
    public function index()
    {
        $sessions = LiveSession::where('is_deleted','0')->latest()->get()->map(function ($session) {
            $session->thumbnail = $session->thumbnail ? asset('storage/' . $session->thumbnail) : null;
            $session->avgFeedback = round((float) Feedback::where('session_id', $session->id)->avg('rating'), 2);
            return $session;
        });
        return response()->json(['live_sessions' => $sessions]);
    }

    public function show(LiveSession $liveSession)
    {
        $liveSession->thumbnail = $liveSession->thumbnail ? asset('storage/' . $liveSession->thumbnail) : null;
        $liveSession->avgFeedback = round((float) Feedback::where('session_id', $liveSession->id)->avg('rating'), 2);
        return response()->json(['live_session' => $liveSession]);
    }
} 