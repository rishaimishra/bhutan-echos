@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Add Question to: {{ $liveQuiz->title }}</h1>
        <a href="{{ route('admin.live-quizzes.questions.index', $liveQuiz) }}" class="btn btn-secondary">Back to Questions</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.live-quizzes.questions.store', $liveQuiz) }}" method="POST" id="questionForm">
                @csrf
                
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <textarea name="question" id="question" class="form-control @error('question') is-invalid @enderror" rows="3" required>{{ old('question') }}</textarea>
                    @error('question')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Question Type</label>
                            <select name="question_type" id="question_type" class="form-control @error('question_type') is-invalid @enderror" required>
                                <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>True/False</option>
                            </select>
                            @error('question_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="order" class="form-label">Order</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Answers</label>
                    <div id="answersContainer">
                        <div class="answer-row mb-2">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="answers[0][answer]" class="form-control" placeholder="Answer 1" required>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="answers[0][is_correct]" class="form-check-input" value="1">
                                        <label class="form-check-label">Correct</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="answers[0][order]" class="form-control" placeholder="Order" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="answer-row mb-2">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="answers[1][answer]" class="form-control" placeholder="Answer 2" required>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="answers[1][is_correct]" class="form-check-input" value="1">
                                        <label class="form-check-label">Correct</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="answers[1][order]" class="form-control" placeholder="Order" value="1" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addAnswer()">Add Answer</button>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.live-quizzes.questions.index', $liveQuiz) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Create Question</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let answerIndex = 2;

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