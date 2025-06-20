@extends('layouts.admin')

@section('title', 'Royal Audio Series')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Audio Clips</p>
                </div>
                <div class="icon">
                    <i class="fas fa-music"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['this_month'] }}</h3>
                    <p>Added This Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['this_year'] }}</h3>
                    <p>Added This Year</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Clips Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Audio Clips</h3>
            <div class="card-tools">
                <a href="{{ route('admin.audio.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Audio
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($clips->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-music fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No audio clips found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Release Date</th>
                                <th>Added On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clips as $clip)
                                <tr>
                                    <td>{{ $clip->title }}</td>
                                    <td>{{ $clip->release_date->format('M d, Y') }}</td>
                                    <td>{{ $clip->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.audio.show', $clip) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.audio.edit', $clip) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.audio.destroy', $clip) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this audio clip?')">
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
                    {{ $clips->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 