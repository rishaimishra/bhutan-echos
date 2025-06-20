@extends('layouts.admin')

@section('title', 'Notification Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Notification Details</h3>
                        <div>
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            @if(!$notification->sent)
                            <a href="{{ route('admin.notifications.edit', $notification) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.notifications.send-now', $notification) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to send this notification now?')">
                                    <i class="fas fa-paper-plane"></i> Send Now
                                </button>
                            </form>
                            <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this notification?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Title</h5>
                        <p class="h4">{{ $notification->title }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Message</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $notification->message }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Status</h5>
                        <span class="badge {{ $notification->sent ? 'bg-success' : 'bg-warning' }} h5">
                            {{ $notification->sent ? 'Sent' : 'Scheduled' }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <h5>Schedule Information</h5>
                        <p class="mb-1">
                            <strong>Scheduled For:</strong>
                            {{ $notification->scheduled_at ? $notification->scheduled_at->format('M d, Y H:i') : 'Not scheduled' }}
                        </p>
                        @if($notification->sent)
                        <p class="mb-1">
                            <strong>Sent At:</strong>
                            {{ $notification->scheduled_at->format('M d, Y H:i') }}
                        </p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5>Notification Details</h5>
                        <p class="mb-1">
                            <strong>Created:</strong> {{ $notification->created_at->format('M d, Y H:i:s') }}
                        </p>
                        @if($notification->created_at != $notification->updated_at)
                        <p class="mb-1">
                            <strong>Last Updated:</strong> {{ $notification->updated_at->format('M d, Y H:i:s') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 