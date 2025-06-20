<?php

namespace App\Http\Controllers;

use App\Models\AuthorSession;
use App\Models\AuthorQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorSessionController extends Controller
{
    public function index()
    {
        $sessions = AuthorSession::where('is_active', true)
            ->orderBy('start_time')
            ->get();
        return view('author_sessions.index', compact('sessions'));
    }

    public function show(AuthorSession $author_session)
    {
        $author_session->load(['questions' => function($q) {
            $q->where('is_approved', true)->with('user')->latest();
        }]);
        return view('author_sessions.show', compact('author_session'));
    }

    public function storeQuestion(Request $request, AuthorSession $author_session)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);
        AuthorQuestion::create([
            'session_id' => $author_session->id,
            'user_id' => Auth::id(),
            'question' => $request->question,
            'is_approved' => false,
        ]);
        return back()->with('success', 'Your question has been submitted and is pending approval.');
    }
} 