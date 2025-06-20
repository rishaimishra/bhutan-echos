@extends('layouts.admin')

@section('title', 'Live Sessions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Live Sessions</h1>
        <a href="{{ route('admin.live-sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Session
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->title }}</td>
                            <td>{{ Str::limit($session->description, 50) }}</td>
                            <td>{{ $session->start_time->format('M d, Y H:i') }}</td>
                            <td>{{ $session->end_time->format('M d, Y H:i') }}</td>
                            <td>
                                @if($session->start_time->isFuture())
                                    <span class="badge bg-info">Upcoming</span>
                                @elseif($session->end_time->isPast())
                                    <span class="badge bg-secondary">Ended</span>
                                @else
                                    <span class="badge bg-success">Live</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.live-sessions.edit', $session) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.live-sessions.destroy', $session) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this session?')">
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