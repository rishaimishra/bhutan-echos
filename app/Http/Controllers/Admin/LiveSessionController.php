<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function index()
    {
        $sessions = LiveSession::latest()->get();
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
        ]);

        LiveSession::create($validated);

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
        ]);

        $liveSession->update($validated);

        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session updated successfully.');
    }

    public function destroy(LiveSession $liveSession)
    {
        $liveSession->delete();

        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session deleted successfully.');
    }
}
