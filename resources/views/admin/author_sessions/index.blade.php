@extends('layouts.admin')

@section('title', 'Author Connect Sessions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Author Connect Sessions</h3>
                    <a href="{{ route('admin.author-sessions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Schedule Session
                    </a>
                </div>
                <div class="card-body">
                    @if($sessions->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Author</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Status</th>
                                        <th>Questions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessions as $session)
                                        <tr>
                                            <td>{{ $session->author_name }}</td>
                                            <td>{{ $session->start_time }}</td>
                                            <td>{{ $session->end_time }}</td>
                                            <td>
                                                @if(!$session->is_active)
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @elseif(now()->lt($session->start_time))
                                                    <span class="badge bg-info">Upcoming</span>
                                                @elseif(now()->between($session->start_time, $session->end_time))
                                                    <span class="badge bg-success">Live</span>
                                                @else
                                                    <span class="badge bg-dark">Ended</span>
                                                @endif
                                            </td>
                                            <td>{{ $session->questions()->count() }}</td>
                                            <td>
                                                <a href="{{ route('admin.author-sessions.show', $session) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.author-sessions.edit', $session) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.author-sessions.destroy', $session) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this session?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $sessions->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center mb-0">
                            No author sessions found. Click "Schedule Session" to add one.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 