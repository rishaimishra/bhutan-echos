@extends('layouts.admin')

@section('title', 'Feedback Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Feedback Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Total Feedback</h5>
                        <h2>{{ $stats['total'] }}</h2>
                    </div>
                    <div class="mb-4">
                        <h5>Average Rating</h5>
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">{{ number_format($stats['average_rating'], 1) }}</h2>
                            <div class="ms-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($stats['average_rating']) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5>Feedback with Comments</h5>
                        <h2>{{ $stats['with_comments'] }}</h2>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Recent Feedback</h3>
                </div>
                <div class="card-body">
                    @foreach($stats['recent'] as $recent)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $recent->user->name ?? 'Anonymous' }}</strong>
                                <div class="text-muted small">
                                    {{ $recent->session->title ?? 'General Feedback' }}
                                </div>
                            </div>
                            @if($recent->rating)
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $recent->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                            @endif
                        </div>
                        @if($recent->comment)
                        <p class="mb-0 mt-1">{{ Str::limit($recent->comment, 50) }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Feedback</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Session</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feedback as $item)
                                <tr>
                                    <td>{{ $item->user->name ?? 'Anonymous' }}</td>
                                    <td>{{ $item->session->title ?? 'General Feedback' }}</td>
                                    <td>
                                        @if($item->rating)
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $item->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                        @else
                                        <span class="text-muted">No rating</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($item->comment, 50) }}</td>
                                    <td>{{ $item->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.feedback.show', $item) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.feedback.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?')">
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

                    <div class="mt-4">
                        {{ $feedback->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 