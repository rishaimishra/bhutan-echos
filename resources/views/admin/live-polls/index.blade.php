@extends('layouts.admin')

@section('title', 'Live Polls')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Live Polls</h1>
        <a href="{{ route('admin.live-polls.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Poll
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
                            <th>Type</th>
                            <th>Options</th>
                            <th>Responses</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($polls as $poll)
                        <tr>
                            <td>{{ $poll->session->title }}</td>
                            <td>{{ $poll->question }}</td>
                            <td>
                                <span class="badge bg-{{ $poll->multiple_choice ? 'info' : 'primary' }}">
                                    {{ $poll->multiple_choice ? 'Multiple Choice' : 'Single Choice' }}
                                </span>
                            </td>
                            <td>{{ $poll->options->count() }}</td>
                            <td>{{ $poll->responses->count() }}</td>
                            <td>{{ $poll->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.live-polls.edit', $poll) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.live-polls.results', $poll) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                    <form action="{{ route('admin.live-polls.destroy', $poll) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this poll?')">
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