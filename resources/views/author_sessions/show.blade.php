@extends('layouts.app')

@section('title', 'Author Session')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Session: {{ $author_session->author_name }}</h3>
                    <a href="{{ route('author-sessions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Sessions
                    </a>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Author Name</dt>
                        <dd class="col-sm-8">{{ $author_session->author_name }}</dd>
                        <dt class="col-sm-4">Bio</dt>
                        <dd class="col-sm-8">{{ $author_session->bio ?? '-' }}</dd>
                        <dt class="col-sm-4">Start Time</dt>
                        <dd class="col-sm-8">{{ $author_session->start_time }}</dd>
                        <dt class="col-sm-4">End Time</dt>
                        <dd class="col-sm-8">{{ $author_session->end_time }}</dd>
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if(!$author_session->is_active)
                                <span class="badge bg-secondary">Inactive</span>
                            @elseif(now()->lt($author_session->start_time))
                                <span class="badge bg-info">Upcoming</span>
                            @elseif(now()->between($author_session->start_time, $author_session->end_time))
                                <span class="badge bg-success">Live</span>
                            @else
                                <span class="badge bg-dark">Ended</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">Approved Questions ({{ $author_session->questions->count() }})</h4>
                </div>
                <div class="card-body">
                    @if($author_session->questions->count())
                        <ul class="list-group">
                            @foreach($author_session->questions as $question)
                                <li class="list-group-item">
                                    <strong>{{ $question->user->name ?? 'User #' . $question->user_id }}:</strong>
                                    <span>{{ $question->question }}</span>
                                    <span class="text-muted float-end small">{{ $question->created_at->format('M d, Y H:i') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info text-center mb-0">
                            No questions have been approved for this session yet.
                        </div>
                    @endif
                </div>
            </div>
            @auth
                @if($author_session->is_active && now()->between($author_session->start_time, $author_session->end_time))
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Submit a Question</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <form action="{{ route('author-sessions.questions.store', $author_session) }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="question">Your Question</label>
                                    <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question" rows="3" required>{{ old('question') }}</textarea>
                                    @error('question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Question</button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-warning text-center">
                    <a href="{{ route('login') }}">Login</a> to submit a question during the live session.
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection 