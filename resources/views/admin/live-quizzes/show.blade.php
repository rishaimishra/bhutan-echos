@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>{{ $liveQuiz->title }}</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Quiz Details</h5>
                    <p><strong>Title:</strong> {{ $liveQuiz->title }}</p>
                    <p><strong>Description:</strong> {{ $liveQuiz->description ?: 'No description' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge {{ $liveQuiz->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $liveQuiz->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    <p><strong>Start Time:</strong> {{ $liveQuiz->start_time ? $liveQuiz->start_time->format('Y-m-d H:i') : 'Not set' }}</p>
                    <p><strong>End Time:</strong> {{ $liveQuiz->end_time ? $liveQuiz->end_time->format('Y-m-d H:i') : 'Not set' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Associated Live Session</h5>
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
    <div class="mt-3">
        <a href="{{ route('admin.live-quizzes.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('admin.live-quizzes.edit', $liveQuiz) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection 