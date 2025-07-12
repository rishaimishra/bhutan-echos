@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Questions for: {{ $liveQuiz->title }}</h1>
        <div>
            <a href="{{ route('admin.live-quizzes.index') }}" class="btn btn-secondary">Back to Live Quizzes</a>
            <a href="{{ route('admin.live-quizzes.questions.create', $liveQuiz) }}" class="btn btn-primary">Add Question</a>
        </div>
    </div>

    @if($questions->count() > 0)
        <div class="row">
            @foreach($questions as $question)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Question {{ $loop->iteration }}</h5>
                            <div>
                                <span class="badge {{ $question->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $question->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="badge bg-info">{{ $question->question_type }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>{{ $question->question }}</strong></p>
                            
                            <h6>Answers:</h6>
                            <ul class="list-unstyled">
                                @foreach($question->answers as $answer)
                                    <li class="mb-2">
                                        <span class="{{ $answer->is_correct ? 'text-success fw-bold' : '' }}">
                                            {{ $loop->iteration }}. {{ $answer->answer }}
                                            @if($answer->is_correct)
                                                <i class="fas fa-check text-success"></i>
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.live-quizzes.questions.show', [$liveQuiz, $question]) }}" class="btn btn-info">View</a>
                                <a href="{{ route('admin.live-quizzes.questions.edit', [$liveQuiz, $question]) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('admin.live-quizzes.questions.destroy', [$liveQuiz, $question]) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            No questions found for this live quiz. <a href="{{ route('admin.live-quizzes.questions.create', $liveQuiz) }}">Add the first question</a>
        </div>
    @endif
</div>
@endsection 