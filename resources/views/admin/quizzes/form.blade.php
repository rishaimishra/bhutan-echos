@extends('layouts.admin')

@section('title', isset($quiz) ? 'Edit Quiz' : 'Create Quiz')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($quiz) ? 'Edit Quiz' : 'Create Quiz' }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ isset($quiz) ? route('admin.quizzes.update', $quiz) : route('admin.quizzes.store') }}" method="POST" id="quizForm">
                        @csrf
                        @if(isset($quiz))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="title">Quiz Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $quiz->title ?? '') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="time_limit">Time Limit (minutes)</label>
                            <input type="number" class="form-control @error('time_limit') is-invalid @enderror" id="time_limit" name="time_limit" value="{{ old('time_limit', $quiz->time_limit ?? '') }}" min="1">
                            <small class="form-text text-muted">Leave empty for no time limit</small>
                            @error('time_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Questions</label>
                            <div id="questions-container">
                                @if(isset($quiz) && $quiz->questions->count() > 0)
                                    @foreach($quiz->questions as $index => $question)
                                        <div class="question-item card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="card-title mb-0">Question {{ $index + 1 }}</h5>
                                                    <button type="button" class="btn btn-danger btn-sm remove-question">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="form-group">
                                                    <label>Question Text</label>
                                                    <input type="text" class="form-control" name="questions[{{ $index }}][question]" value="{{ $question->question }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Options</label>
                                                    @foreach($question->options as $optionIndex => $option)
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="questions[{{ $index }}][correct_answer]" value="{{ $option }}" {{ $option === $question->correct_answer ? 'checked' : '' }} required>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" required>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-danger remove-option">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <button type="button" class="btn btn-secondary btn-sm add-option" data-question="{{ $index }}">
                                                        <i class="fas fa-plus"></i> Add Option
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-success" id="add-question">
                                <i class="fas fa-plus"></i> Add Question
                            </button>
                            @error('questions')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">{{ isset($quiz) ? 'Update' : 'Create' }} Quiz</button>
                            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = {{ isset($quiz) ? $quiz->questions->count() : 0 }};
    const questionsContainer = document.getElementById('questions-container');
    const addQuestionBtn = document.getElementById('add-question');

    // Add new question
    addQuestionBtn.addEventListener('click', function() {
        const questionHtml = `
            <div class="question-item card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Question ${questionCount + 1}</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-question">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Question Text</label>
                        <input type="text" class="form-control" name="questions[${questionCount}][question]" required>
                    </div>
                    <div class="form-group">
                        <label>Options</label>
                        <div class="options-container">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[${questionCount}][correct_answer]" value="0" required>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="questions[${questionCount}][options][]" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-option">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[${questionCount}][correct_answer]" value="1" required>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="questions[${questionCount}][options][]" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-option">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm add-option" data-question="${questionCount}">
                            <i class="fas fa-plus"></i> Add Option
                        </button>
                    </div>
                </div>
            </div>
        `;
        questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
        questionCount++;
        updateQuestionNumbers();
    });

    // Remove question
    questionsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            e.target.closest('.question-item').remove();
            questionCount--;
            updateQuestionNumbers();
        }
    });

    // Add option
    questionsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.add-option')) {
            const questionIndex = e.target.closest('.add-option').dataset.question;
            const optionsContainer = e.target.closest('.form-group').querySelector('.options-container');
            const optionCount = optionsContainer.children.length;
            
            const optionHtml = `
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" name="questions[${questionIndex}][correct_answer]" value="${optionCount}" required>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="questions[${questionIndex}][options][]" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-option">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
        }
    });

    // Remove option
    questionsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-option')) {
            const optionsContainer = e.target.closest('.options-container');
            if (optionsContainer.children.length > 2) {
                e.target.closest('.input-group').remove();
            } else {
                alert('A question must have at least 2 options.');
            }
        }
    });

    // Update question numbers
    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-item');
        questions.forEach((question, index) => {
            question.querySelector('.card-title').textContent = `Question ${index + 1}`;
            const inputs = question.querySelectorAll('input[name^="questions["]');
            inputs.forEach(input => {
                const name = input.name;
                input.name = name.replace(/questions\[\d+\]/, `questions[${index}]`);
            });
        });
    }

    // Form validation
    document.getElementById('quizForm').addEventListener('submit', function(e) {
        const questions = questionsContainer.querySelectorAll('.question-item');
        if (questions.length === 0) {
            e.preventDefault();
            alert('Please add at least one question.');
            return;
        }

        let isValid = true;
        questions.forEach(question => {
            const options = question.querySelectorAll('input[name$="[options][]"]');
            if (options.length < 2) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Each question must have at least 2 options.');
        }
    });
});
</script>
@endpush 