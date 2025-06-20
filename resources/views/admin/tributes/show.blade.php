@extends('layouts.admin')

@section('title', 'Tribute Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Tribute Details</h3>
                        <div>
                            <a href="{{ route('admin.tributes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            @if(!$tribute->approved)
                            <form action="{{ route('admin.tributes.approve', $tribute) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this tribute?')">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.tributes.reject', $tribute) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to reject this tribute?')">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.tributes.destroy', $tribute) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this tribute?')">
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
                                <strong>Name:</strong> {{ $tribute->user->name ?? 'Anonymous' }}
                            </p>
                            @if($tribute->user)
                            <p class="mb-1">
                                <strong>Email:</strong> {{ $tribute->user->email }}
                            </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Tribute Information</h5>
                            <p class="mb-1">
                                <strong>Type:</strong>
                                <span class="badge bg-info">
                                    {{ ucfirst(str_replace('_', ' ', $tribute->type)) }}
                                </span>
                            </p>
                            <p class="mb-1">
                                <strong>Status:</strong>
                                <span class="badge {{ $tribute->approved ? 'bg-success' : 'bg-warning' }}">
                                    {{ $tribute->approved ? 'Approved' : 'Pending' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($tribute->description)
                    <div class="mb-4">
                        <h5>Description</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $tribute->description }}
                        </div>
                    </div>
                    @endif

                    @if($tribute->media_path)
                    <div class="mb-4">
                        <h5>Media</h5>
                        @if($tribute->type === 'voice_note')
                        <audio controls class="w-100">
                            <source src="{{ asset($tribute->media_path) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        @elseif($tribute->type === 'artwork')
                        <img src="{{ asset($tribute->media_path) }}" alt="Artwork" class="img-fluid rounded">
                        @endif
                    </div>
                    @endif

                    <div class="mb-4">
                        <h5>Tribute Details</h5>
                        <p class="mb-1">
                            <strong>Submitted:</strong> {{ $tribute->created_at->format('M d, Y H:i:s') }}
                        </p>
                        @if($tribute->created_at != $tribute->updated_at)
                        <p class="mb-1">
                            <strong>Last Updated:</strong> {{ $tribute->updated_at->format('M d, Y H:i:s') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 