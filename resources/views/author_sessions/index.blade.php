@extends('layouts.app')

@section('title', 'Author Connect Sessions')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Author Connect Sessions</h2>
    <div class="row">
        @forelse($sessions as $session)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $session->author_name }}</h5>
                        <p class="card-text mb-1"><strong>Start:</strong> {{ $session->start_time }}</p>
                        <p class="card-text mb-1"><strong>End:</strong> {{ $session->end_time }}</p>
                        <p class="card-text mb-2">
                            <strong>Status:</strong>
                            @if(!$session->is_active)
                                <span class="badge bg-secondary">Inactive</span>
                            @elseif(now()->lt($session->start_time))
                                <span class="badge bg-info">Upcoming</span>
                            @elseif(now()->between($session->start_time, $session->end_time))
                                <span class="badge bg-success">Live</span>
                            @else
                                <span class="badge bg-dark">Ended</span>
                            @endif
                        </p>
                        <a href="{{ route('author-sessions.show', $session) }}" class="btn btn-primary mt-auto">
                            <i class="fas fa-comments"></i> Join/View
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No author sessions available at the moment. Please check back later!
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection 