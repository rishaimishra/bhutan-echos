@extends('layouts.admin')

@section('title', 'Feedback Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Feedback Details</h3>
                        <div>
                            <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>User Information</h5>
                            <p class="mb-1">
                                <strong>Name:</strong> {{ $feedback->user->name ?? 'Anonymous' }}
                            </p>
                            @if($feedback->user)
                            <p class="mb-1">
                                <strong>Email:</strong> {{ $feedback->user->email }}
                            </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Session Information</h5>
                            <p class="mb-1">
                                <strong>Session:</strong> {{ $feedback->session->title ?? 'General Feedback' }}
                            </p>
                            @if($feedback->session)
                            <p class="mb-1">
                                <strong>Date:</strong> {{ $feedback->session->start_time->format('M d, Y H:i') }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Rating</h5>
                        @if($feedback->rating)
                        <div class="text-warning h4">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            <span class="text-dark ms-2">{{ $feedback->rating }}/5</span>
                        </div>
                        @else
                        <p class="text-muted">No rating provided</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5>Comment</h5>
                        @if($feedback->comment)
                        <div class="p-3 bg-light rounded">
                            {{ $feedback->comment }}
                        </div>
                        @else
                        <p class="text-muted">No comment provided</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5>Feedback Details</h5>
                        <p class="mb-1">
                            <strong>Submitted:</strong> {{ $feedback->created_at->format('M d, Y H:i:s') }}
                        </p>
                        @if($feedback->created_at != $feedback->updated_at)
                        <p class="mb-1">
                            <strong>Last Updated:</strong> {{ $feedback->updated_at->format('M d, Y H:i:s') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 