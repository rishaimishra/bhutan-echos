<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthorQuestion;
use Illuminate\Http\RedirectResponse;

class AuthorQuestionController extends Controller
{
    public function approve(AuthorQuestion $author_question): RedirectResponse
    {
        $author_question->update(['is_approved' => true]);
        return back()->with('success', 'Question approved.');
    }

    public function destroy(AuthorQuestion $author_question): RedirectResponse
    {
        $author_question->delete();
        return back()->with('success', 'Question deleted.');
    }
} 