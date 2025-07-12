@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Question Details</h1>
        <div>
            <a href="{{ route('admin.live-quizzes.questions.index', $liveQuiz) }}" class="btn btn-secondary">Back to Questions</a>
            <a href="{{ route('admin.live-quizzes.questions.edit', [$liveQuiz, $question]) }}" class="btn btn-warning">Edit Question</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Question Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Question:</strong>
                        <p class="mt-2">{{ $question->question }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Question Type:</strong>
                            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $question->question_type)) }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <span class="badge {{ $question->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $question->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Order:</strong> {{ $question->order }}
                    </div>

                    <div class="mb-3">
                        <strong>Answers:</strong>
                        <div class="mt-2">
                            @foreach($question->answers as $index => $answer)
                                <div class="card mb-2 {{ $answer->is_correct ? 'border-success' : 'border-secondary' }}">
                                    <div class="card-body py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="{{ $answer->is_correct ? 'text-success fw-bold' : '' }}">
                                                {{ $index + 1 }}. {{ $answer->answer }}
                                            </span>
                                            <div>
                                                @if($answer->is_correct)
                                                    <i class="fas fa-check text-success"></i>
                                                    <span class="badge bg-success">Correct</span>
                                                @endif
                                                <span class="badge bg-secondary">Order: {{ $answer->order }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Live Quiz Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Quiz Title:</strong> {{ $liveQuiz->title }}</p>
                    <p><strong>Quiz Description:</strong> {{ $liveQuiz->description ?: 'No description' }}</p>
                    <p><strong>Quiz Status:</strong> 
                        <span class="badge {{ $liveQuiz->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $liveQuiz->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    @if($liveQuiz->start_time)
                        <p><strong>Quiz Start:</strong> {{ $liveQuiz->start_time->format('Y-m-d H:i') }}</p>
                    @endif
                    @if($liveQuiz->end_time)
                        <p><strong>Quiz End:</strong> {{ $liveQuiz->end_time->format('Y-m-d H:i') }}</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Live Session Information</h5>
                </div>
                <div class="card-body">
                    @if($liveQuiz->liveSession)
                        <p><strong>Session Title:</strong> {{ $liveQuiz->liveSession->title }}</p>
                        <p><strong>Session Description:</strong> {{ $liveQuiz->liveSession->description }}</p>
                        <p><strong>Session Start:</strong> {{ $liveQuiz->liveSession->start_time->format('Y-m-d H:i') }}</p>
                        <p><strong>Session End:</strong> {{ $liveQuiz->liveSession->end_time->format('Y-m-d H:i') }}</p>
                    @else
                        <p class="text-muted">No live session associated</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 