@extends('layouts.admin')

@section('title', 'Quiz Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quiz Details: {{ $quiz->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Quiz
                        </a>
                        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $quiz->questions->count() }}</h3>
                                    <p>Total Questions</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-list"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $quiz->results->count() }}</h3>
                                    <p>Total Attempts</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ number_format($quiz->getAverageScore(), 1) }}%</h3>
                                    <p>Average Score</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}</h3>
                                    <p>Time Limit</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Questions</h4>
                                </div>
                                <div class="card-body">
                                    @foreach($quiz->questions as $index => $question)
                                        <div class="question-item mb-4">
                                            <h5>Question {{ $index + 1 }}</h5>
                                            <p class="mb-2">{{ $question->question }}</p>
                                            <div class="options">
                                                @foreach($question->options as $option)
                                                    <div class="option {{ $option === $question->correct_answer ? 'text-success' : '' }}">
                                                        <i class="fas {{ $option === $question->correct_answer ? 'fa-check-circle' : 'fa-circle' }}"></i>
                                                        {{ $option }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Recent Results</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Score</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($quiz->results as $result)
                                                    <tr>
                                                        <td>{{ $result->user->name }}</td>
                                                        <td>{{ $result->score }}%</td>
                                                        <td>{{ $result->created_at->format('M d, Y H:i') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">No results yet.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 