@extends('layouts.admin')

@section('title', 'Timeline Management')

@section('content')
<div class="container-fluid">
    <!-- Statistics Card -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Timeline Entries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-history"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['by_type']['image'] }}</h3>
                    <p>Image Entries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-image"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['by_type']['video'] }}</h3>
                    <p>Video Entries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-video"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['by_decade'] }}</h3>
                    <p>Unique Decades</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Entries Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Timeline Entries</h3>
            <div class="card-tools">
                <a href="{{ route('admin.timeline.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Entry
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($entries->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No timeline entries found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Decade</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entries as $entry)
                                <tr>
                                    <td>{{ $entry->title }}</td>
                                    <td>
                                        <span class="badge badge-{{ $entry->media_type === 'image' ? 'success' : ($entry->media_type === 'video' ? 'warning' : 'info') }}">
                                            {{ ucfirst($entry->media_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $entry->decade ?? 'N/A' }}</td>
                                    <td>{{ $entry->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.timeline.show', $entry) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.timeline.edit', $entry) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.timeline.destroy', $entry) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this entry?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $entries->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 