<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthorSession;
use Illuminate\Http\Request;

class AuthorSessionController extends Controller
{
    public function index()
    {
        $sessions = AuthorSession::orderByDesc('start_time')->paginate(10);
        return view('admin.author_sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.author_sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'is_active' => 'boolean',
        ]);
        AuthorSession::create($validated);
        return redirect()->route('admin.author-sessions.index')->with('success', 'Session created successfully.');
    }

    public function show(AuthorSession $author_session)
    {
        $author_session->load(['questions.user']);
        return view('admin.author_sessions.show', compact('author_session'));
    }

    public function edit(AuthorSession $author_session)
    {
        return view('admin.author_sessions.edit', compact('author_session'));
    }

    public function update(Request $request, AuthorSession $author_session)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'is_active' => 'boolean',
        ]);
        $author_session->update($validated);
        return redirect()->route('admin.author-sessions.index')->with('success', 'Session updated successfully.');
    }

    public function destroy(AuthorSession $author_session)
    {
        $author_session->delete();
        return redirect()->route('admin.author-sessions.index')->with('success', 'Session deleted successfully.');
    }
} 