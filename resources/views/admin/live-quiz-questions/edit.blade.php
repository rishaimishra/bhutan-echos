@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Edit Question for: {{ $liveQuiz->title }}</h1>
        <a href="{{ route('admin.live-quizzes.questions.index', $liveQuiz) }}" class="btn btn-secondary">Back to Questions</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.live-quizzes.questions.update', [$liveQuiz, $question]) }}" method="POST" id="questionForm">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <textarea name="question" id="question" class="form-control @error('question') is-invalid @enderror" rows="3" required>{{ old('question', $question->question) }}</textarea>
                    @error('question')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Question Type</label>
                            <select name="question_type" id="question_type" class="form-control @error('question_type') is-invalid @enderror" required>
                                <option value="multiple_choice" {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="true_false" {{ old('question_type', $question->question_type) == 'true_false' ? 'selected' : '' }}>True/False</option>
                            </select>
                            @error('question_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="order" class="form-label">Order</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $question->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $question->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Answers</label>
                    <div id="answersContainer">
                        @foreach($question->answers as $index => $answer)
                            <div class="answer-row mb-2">
                                <input type="hidden" name="answers[{{ $index }}][id]" value="{{ $answer->id }}">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" name="answers[{{ $index }}][answer]" class="form-control" placeholder="Answer {{ $index + 1 }}" value="{{ $answer->answer }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="answers[{{ $index }}][is_correct]" class="form-check-input" value="1" {{ $answer->is_correct ? 'checked' : '' }}>
                                            <label class="form-check-label">Correct</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="answers[{{ $index }}][order]" class="form-control" placeholder="Order" value="{{ $answer->order }}" min="0">
                                    </div>
                                    @if($index > 1)
                                        <div class="col-md-12 mt-1">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAnswer(this)">Remove</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addAnswer()">Add Answer</button>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.live-quizzes.questions.index', $liveQuiz) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Question</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let answerIndex = {{ $question->answers->count() }};

function addAnswer() {
    const container = document.getElementById('answersContainer');
    const newRow = document.createElement('div');
    newRow.className = 'answer-row mb-2';
    newRow.innerHTML = `
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="answers[${answerIndex}][answer]" class="form-control" placeholder="Answer ${answerIndex + 1}" required>
            </div>
            <div class="col-md-2">
                <div class="form-check">
                    <input type="checkbox" name="answers[${answerIndex}][is_correct]" class="form-check-input" value="1">
                    <label class="form-check-label">Correct</label>
                </div>
            </div>
            <div class="col-md-2">
                <input type="number" name="answers[${answerIndex}][order]" class="form-control" placeholder="Order" value="${answerIndex}" min="0">
            </div>
            <div class="col-md-12 mt-1">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAnswer(this)">Remove</button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    answerIndex++;
}

function removeAnswer(button) {
    button.closest('.answer-row').remove();
}
</script>
@endsection 