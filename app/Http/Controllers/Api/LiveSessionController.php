<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function index()
    {
        $sessions = LiveSession::latest()->get()->map(function ($session) {
            $session->thumbnail = $session->thumbnail ? asset('storage/' . $session->thumbnail) : null;
            return $session;
        });
        return response()->json(['live_sessions' => $sessions]);
    }

    public function show(LiveSession $liveSession)
    {
        $liveSession->thumbnail = $liveSession->thumbnail ? asset('storage/' . $liveSession->thumbnail) : null;
        return response()->json(['live_session' => $liveSession]);
    }
} 