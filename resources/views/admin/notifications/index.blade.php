@extends('layouts.admin')

@section('title', 'Notifications Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Notification Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Total Notifications</h5>
                        <h2>{{ $stats['total'] }}</h2>
                    </div>
                    <div class="mb-4">
                        <h5>Scheduled Notifications</h5>
                        <h2>{{ $stats['scheduled'] }}</h2>
                    </div>
                    <div class="mb-4">
                        <h5>Sent Notifications</h5>
                        <h2>{{ $stats['sent'] }}</h2>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Recent Notifications</h3>
                </div>
                <div class="card-body">
                    @foreach($stats['recent'] as $recent)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $recent->title }}</strong>
                                <div class="text-muted small">
                                    {{ $recent->scheduled_at ? $recent->scheduled_at->format('M d, Y H:i') : 'Not scheduled' }}
                                </div>
                            </div>
                            <span class="badge {{ $recent->sent ? 'bg-success' : 'bg-warning' }}">
                                {{ $recent->sent ? 'Sent' : 'Scheduled' }}
                            </span>
                        </div>
                        <p class="mb-0 mt-1">{{ Str::limit($recent->message, 50) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">All Notifications</h3>
                        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Notification
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Scheduled For</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ Str::limit($notification->message, 50) }}</td>
                                    <td>
                                        {{ $notification->scheduled_at ? $notification->scheduled_at->format('M d, Y H:i') : 'Not scheduled' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $notification->sent ? 'bg-success' : 'bg-warning' }}">
                                            {{ $notification->sent ? 'Sent' : 'Scheduled' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.notifications.show', $notification) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$notification->sent)
                                            <a href="{{ route('admin.notifications.edit', $notification) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.notifications.send-now', $notification) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to send this notification now?')">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this notification?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 