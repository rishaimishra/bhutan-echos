@extends('layouts.admin')

@section('title', 'Timeline Entry Details')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Timeline Entry Details</h3>
            <div class="card-tools">
                <a href="{{ route('admin.timeline.edit', $timeline) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.timeline.destroy', $timeline) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this entry?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>{{ $timeline->title }}</h4>
                    <p class="text-muted">
                        <i class="fas fa-calendar-alt"></i> Decade: {{ $timeline->decade ?? 'Not specified' }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-clock"></i> Created: {{ $timeline->created_at->format('M d, Y H:i') }}
                    </p>
                    <div class="mt-4">
                        <h5>Description</h5>
                        <p>{{ $timeline->description }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Media</h5>
                        </div>
                        <div class="card-body">
                            @if($timeline->media_type === 'image' && $timeline->media_url)
                                <img src="{{ $timeline->media_url }}" alt="{{ $timeline->title }}" class="img-fluid">
                            @elseif($timeline->media_type === 'video' && $timeline->media_url)
                                <video controls class="img-fluid">
                                    <source src="{{ $timeline->media_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <p class="text-muted">No media available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.timeline.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection 