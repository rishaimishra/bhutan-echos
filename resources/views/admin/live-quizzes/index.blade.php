@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Live Quizzes</h1>
        <a href="{{ route('admin.live-quizzes.create') }}" class="btn btn-primary">Create Live Quiz</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Live Session</th>
                <th>Status</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->id }}</td>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->liveSession->title ?? 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $quiz->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $quiz->start_time ? $quiz->start_time->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>{{ $quiz->end_time ? $quiz->end_time->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.live-quizzes.show', $quiz) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.live-quizzes.edit', $quiz) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('admin.live-quizzes.questions.create', $quiz) }}" class="btn btn-success btn-sm">Create Question</a>
                        <a href="{{ route('admin.live-quizzes.questions.index', $quiz) }}" class="btn btn-success btn-sm">View Questions</a>
                        <form action="{{ route('admin.live-quizzes.destroy', $quiz) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $quizzes->links() }}
</div>
@endsection 