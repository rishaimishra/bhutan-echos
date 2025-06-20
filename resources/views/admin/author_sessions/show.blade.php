@extends('layouts.admin')

@section('title', 'Session Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Session: {{ $author_session->author_name }}</h3>
                    <a href="{{ route('admin.author-sessions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Author Name</dt>
                        <dd class="col-sm-9">{{ $author_session->author_name }}</dd>
                        <dt class="col-sm-3">Bio</dt>
                        <dd class="col-sm-9">{{ $author_session->bio ?? '-' }}</dd>
                        <dt class="col-sm-3">Start Time</dt>
                        <dd class="col-sm-9">{{ $author_session->start_time }}</dd>
                        <dt class="col-sm-3">End Time</dt>
                        <dd class="col-sm-9">{{ $author_session->end_time }}</dd>
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Submitted Questions ({{ $author_session->questions->count() }})</h4>
                </div>
                <div class="card-body">
                    @if($author_session->questions->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Question</th>
                                        <th>Submitted At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($author_session->questions as $question)
                                        <tr>
                                            <td>{{ $question->user->name ?? 'User #' . $question->user_id }}</td>
                                            <td>{{ $question->question }}</td>
                                            <td>{{ $question->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                @if($question->is_approved)
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$question->is_approved)
                                                    <form action="{{ route('admin.author-questions.approve', $question) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.author-questions.destroy', $question) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center mb-0">
                            No questions submitted for this session yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 