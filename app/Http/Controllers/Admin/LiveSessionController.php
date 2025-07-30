<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use Illuminate\Http\Request;
use App\Models\User;
use App\Service\FirebaseService;

class LiveSessionController extends Controller
{
    public function index()
    {
        $sessions = LiveSession::where('is_deleted','0')->latest()->get();
        return view('admin.live-sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.live-sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'thumbnail' => 'nullable|image',
            'youtube_link' => 'nullable|string|max:255',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('live_sessions/thumbnails', 'public');
        }

        $session = LiveSession::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'thumbnail' => $thumbnailPath,
            'youtube_link' => $validated['youtube_link'] ?? null,
        ]);

        $tokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();

        if (!empty($tokens)) {
            $expoService = new FirebaseService();

            $expoService->sendNotification(
                $tokens,
                'New Live Event: ' . $session->title,
                'Join us live on ' . date('M d, Y h:i A', strtotime($session->start_time)),
                [
                    'live_session_id' => $session->id,
                    'type' => 'live'
                ]
            );
        }


        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session created successfully.');
    }

    public function edit(LiveSession $liveSession)
    {
        return view('admin.live-sessions.edit', compact('liveSession'));
    }

    public function update(Request $request, LiveSession $liveSession)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'thumbnail' => 'nullable|image',
            'youtube_link' => 'nullable|string|max:255',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = $liveSession->thumbnail;
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($liveSession->thumbnail) {
                \Storage::disk('public')->delete($liveSession->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('live_sessions/thumbnails', 'public');
        }

        $liveSession->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'thumbnail' => $thumbnailPath,
            'youtube_link' => $validated['youtube_link'] ?? null,
        ]);

        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session updated successfully.');
    }

    public function destroy(LiveSession $liveSession)
    {
        $liveSession->update(['is_deleted'=>1]);

        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session deleted successfully.');
    }
}
