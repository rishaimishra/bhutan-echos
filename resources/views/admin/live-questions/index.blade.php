@extends('layouts.admin')

@section('title', 'Live Questions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Live Questions</h1>
        <a href="{{ route('admin.live-questions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Question
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Session</th>
                            <th>Question</th>
                            <th>Asked By</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->session->title }}</td>
                            <td>{{ Str::limit($question->question, 100) }}</td>
                            <td>{{ $question->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $question->status === 'approved' ? 'success' : ($question->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($question->status) }}
                                </span>
                            </td>
                            <td>{{ $question->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.live-questions.edit', $question) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.live-questions.destroy', $question) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this question?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 