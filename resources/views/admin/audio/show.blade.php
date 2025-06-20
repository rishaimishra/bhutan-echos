@extends('layouts.admin')

@section('title', 'Audio Clip Details')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Audio Clip Details</h3>
            <div class="card-tools">
                <a href="{{ route('admin.audio.edit', $audio) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.audio.destroy', $audio) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this audio clip?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>{{ $audio->title }}</h4>
                    <p class="text-muted">
                        <i class="fas fa-calendar-alt"></i> Release Date: {{ $audio->release_date->format('M d, Y') }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-clock"></i> Added: {{ $audio->created_at->format('M d, Y H:i') }}
                    </p>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Audio Player</h5>
                        </div>
                        <div class="card-body">
                            <audio controls class="w-100">
                                <source src="{{ $audio->audio_url }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection 