@extends('layouts.admin')

@section('title', 'Content Details')

@section('content')
@php
    $mediaUrls = [];
    if ($audio->media_url) {
        $mediaUrls = $audio->media_type === 'image' ? json_decode($audio->media_url, true) : [$audio->media_url];
    }
@endphp

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Content Details</h3>
            <div class="card-tools">
                <a href="{{ route('admin.audio.edit', $audio) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.audio.destroy', $audio) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this content?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>{{ $audio->title }}</h4>
                    @if($audio->description)
                        <p class="text-muted mb-2">{{ $audio->description }}</p>
                    @endif
                    <p class="text-muted">
                        <i class="fas fa-tag"></i> Type: {{ ucfirst($audio->media_type) }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-calendar-alt"></i> Release Date: {{ $audio->release_date->format('M d, Y') }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-clock"></i> Added: {{ $audio->created_at->format('M d, Y H:i') }}
                    </p>
                </div>
                
                @if($audio->media_type !== 'text' && !empty($mediaUrls))
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                @if($audio->media_type === 'image' && count($mediaUrls) > 1)
                                    Image Gallery
                                @else
                                    {{ ucfirst($audio->media_type) }} Preview
                                @endif
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @if($audio->media_type == 'audio')
                                <audio controls class="w-100" style="max-width: 600px;">
                                    <source src="{{ url($mediaUrls[0]) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <div class="mt-2">
                                    <a href="{{ url($mediaUrls[0]) }}" class="btn btn-sm btn-outline-primary" download>
                                        <i class="fas fa-download"></i> Download Audio
                                    </a>
                                </div>
                            @elseif($audio->media_type == 'video')
                                <video controls class="w-100" style="max-height: 400px;">
                                    <source src="{{ url($mediaUrls[0]) }}" type="video/mp4">
                                    Your browser does not support the video element.
                                </video>
                                <div class="mt-2">
                                    <a href="{{ url($mediaUrls[0]) }}" class="btn btn-sm btn-outline-primary" download>
                                        <i class="fas fa-download"></i> Download Video
                                    </a>
                                </div>
                            @elseif($audio->media_type == 'image')
                                <div class="row">
                                    @foreach($mediaUrls as $url)
                                        <div class="col-md-4 mb-4">
                                            <img src="{{ url($url) }}" class="img-fluid rounded shadow" style="max-height: 300px;" alt="{{ $audio->title }}">
                                            <div class="mt-2">
                                                <a href="{{ url($url) }}" class="btn btn-sm btn-outline-primary" download>
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
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