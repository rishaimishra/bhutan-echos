@extends('layouts.admin')

@section('title', 'Tribute Wall Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tribute Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Total Tributes</h5>
                        <h2>{{ $stats['total'] }}</h2>
                    </div>
                    <div class="mb-4">
                        <h5>Pending Approval</h5>
                        <h2>{{ $stats['pending'] }}</h2>
                    </div>
                    <div class="mb-4">
                        <h5>Approved Tributes</h5>
                        <h2>{{ $stats['approved'] }}</h2>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Tributes by Type</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Poems</h6>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $stats['total'] > 0 ? ($stats['by_type']['poem'] / $stats['total']) * 100 : 0 }}%">
                                {{ $stats['by_type']['poem'] }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6>Artwork</h6>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $stats['total'] > 0 ? ($stats['by_type']['artwork'] / $stats['total']) * 100 : 0 }}%">
                                {{ $stats['by_type']['artwork'] }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6>Blessings</h6>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $stats['total'] > 0 ? ($stats['by_type']['blessing'] / $stats['total']) * 100 : 0 }}%">
                                {{ $stats['by_type']['blessing'] }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6>Voice Notes</h6>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $stats['total'] > 0 ? ($stats['by_type']['voice_note'] / $stats['total']) * 100 : 0 }}%">
                                {{ $stats['by_type']['voice_note'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Tributes</h3>
                </div>
                <div class="card-body">
                    @if($tributes->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h4>No Tributes Yet</h4>
                        <p class="text-muted">There are no tributes in the system yet.</p>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tributes as $tribute)
                                <tr>
                                    <td>{{ $tribute->user->name ?? 'Anonymous' }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst(str_replace('_', ' ', $tribute->type)) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($tribute->description, 50) }}</td>
                                    <td>
                                        <span class="badge {{ $tribute->approved ? 'bg-success' : 'bg-warning' }}">
                                            {{ $tribute->approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>{{ $tribute->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tributes.show', $tribute) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$tribute->approved)
                                            <form action="{{ route('admin.tributes.approve', $tribute) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to approve this tribute?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('admin.tributes.reject', $tribute) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to reject this tribute?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <form action="{{ route('admin.tributes.destroy', $tribute) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tribute?')">
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
                        {{ $tributes->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 