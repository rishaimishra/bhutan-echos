<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveQuiz;
use App\Models\LiveQuizQuestion;
use App\Models\LiveQuizAnswer;
use Illuminate\Http\Request;

class LiveQuizQuestionController extends Controller
{
    public function index(LiveQuiz $liveQuiz)
    {
        $questions = $liveQuiz->questions()->with('answers')->orderBy('order')->get();
        return view('admin.live-quiz-questions.index', compact('liveQuiz', 'questions'));
    }

    public function create(LiveQuiz $liveQuiz)
    {
        return view('admin.live-quiz-questions.create', compact('liveQuiz'));
    }

    public function store(Request $request, LiveQuiz $liveQuiz)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'answers' => 'required|array|min:2',
            'answers.*.answer' => 'required|string',
            'answers.*.is_correct' => 'boolean',
            'answers.*.order' => 'nullable|integer|min:0',
        ]);

        $question = $liveQuiz->questions()->create([
            'question' => $validated['question'],
            'question_type' => $validated['question_type'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Create answers
        foreach ($validated['answers'] as $answerData) {
            $question->answers()->create([
                'answer' => $answerData['answer'],
                'is_correct' => $answerData['is_correct'] ?? false,
                'order' => $answerData['order'] ?? 0,
            ]);
        }

        return redirect()->route('admin.live-quizzes.questions.index', $liveQuiz)
            ->with('success', 'Question created successfully.');
    }

    public function show(LiveQuiz $liveQuiz, LiveQuizQuestion $question)
    {
        $question->load('answers');
        return view('admin.live-quiz-questions.show', compact('liveQuiz', 'question'));
    }

    public function edit(LiveQuiz $liveQuiz, LiveQuizQuestion $question)
    {
        $question->load('answers');
        return view('admin.live-quiz-questions.edit', compact('liveQuiz', 'question'));
    }

    public function update(Request $request, LiveQuiz $liveQuiz, LiveQuizQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'answers' => 'required|array|min:2',
            'answers.*.id' => 'nullable|exists:live_quiz_answers,id',
            'answers.*.answer' => 'required|string',
            'answers.*.is_correct' => 'boolean',
            'answers.*.order' => 'nullable|integer|min:0',
        ]);

        $question->update([
            'question' => $validated['question'],
            'question_type' => $validated['question_type'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Update or create answers
        $existingAnswerIds = [];
        foreach ($validated['answers'] as $answerData) {
            if (isset($answerData['id'])) {
                // Update existing answer
                $question->answers()->where('id', $answerData['id'])->update([
                    'answer' => $answerData['answer'],
                    'is_correct' => $answerData['is_correct'] ?? false,
                    'order' => $answerData['order'] ?? 0,
                ]);
                $existingAnswerIds[] = $answerData['id'];
            } else {
                // Create new answer
                $question->answers()->create([
                    'answer' => $answerData['answer'],
                    'is_correct' => $answerData['is_correct'] ?? false,
                    'order' => $answerData['order'] ?? 0,
                ]);
            }
        }

        // Delete answers that are no longer in the form
        $question->answers()->whereNotIn('id', $existingAnswerIds)->delete();

        return redirect()->route('admin.live-quizzes.questions.index', $liveQuiz)
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(LiveQuiz $liveQuiz, LiveQuizQuestion $question)
    {
        $question->delete();

        return redirect()->route('admin.live-quizzes.questions.index', $liveQuiz)
            ->with('success', 'Question deleted successfully.');
    }
}
