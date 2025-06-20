<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::with(['session', 'user'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Feedback::count(),
            'average_rating' => Feedback::whereNotNull('rating')->avg('rating'),
            'with_comments' => Feedback::whereNotNull('comment')->count(),
            'recent' => Feedback::with(['session', 'user'])
                ->latest()
                ->take(5)
                ->get()
        ];

        return view('admin.feedback.index', compact('feedback', 'stats'));
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['session', 'user']);
        return view('admin.feedback.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }
} 