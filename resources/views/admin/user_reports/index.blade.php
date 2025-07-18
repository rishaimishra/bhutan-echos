@extends('layouts.admin')

@section('title', 'User Reports')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">User Reports</h1>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reporter</th>
                            <th>Reported User</th>
                            <th>Reason</th>
                            <th>Details</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->reporter->name ?? 'N/A' }}<br><small>{{ $report->reporter->email ?? '' }}</small></td>
                            <td>{{ $report->reported->name ?? 'N/A' }}<br><small>{{ $report->reported->email ?? '' }}</small></td>
                            <td>{{ $report->reason }}</td>
                            <td>{{ $report->details }}</td>
                            <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($report->reported && !$report->reported->blocked)
                                    <form action="{{ route('admin.user-reports.block', $report->reported->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Block this user?')">
                                            <i class="fas fa-ban"></i> Block
                                        </button>
                                    </form>
                                @elseif($report->reported && $report->reported->blocked)
                                    <form action="{{ route('admin.user-reports.unblock', $report->reported->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Unblock this user?')">
                                            <i class="fas fa-unlock"></i> Unblock
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No reports found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 