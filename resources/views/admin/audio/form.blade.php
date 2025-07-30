@extends('layouts.admin')

@section('title', 'Edit Content')

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
            <h3 class="card-title">Edit Content</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.audio.update', $audio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $audio->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $audio->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="media_type">Content Type</label>
                    <select class="form-control @error('media_type') is-invalid @enderror" id="media_type" name="media_type" required>
                        <option value="text" {{ old('media_type', $audio->media_type) == 'text' ? 'selected' : '' }}>Text Only</option>
                        <option value="audio" {{ old('media_type', $audio->media_type) == 'audio' ? 'selected' : '' }}>Audio</option>
                        <option value="video" {{ old('media_type', $audio->media_type) == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="image" {{ old('media_type', $audio->media_type) == 'image' ? 'selected' : '' }}>Image</option>
                    </select>
                    @error('media_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div id="file-input-container">
                    @if($audio->media_type === 'audio')
                        @include('admin.audio.audio-input', ['mediaUrls' => $mediaUrls])
                    @elseif($audio->media_type === 'video')
                        @include('admin.audio.video-input', ['mediaUrls' => $mediaUrls])
                    @elseif($audio->media_type === 'image')
                        @include('admin.audio.image-input', ['mediaUrls' => $mediaUrls])
                    @endif
                </div>

                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" value="{{ old('release_date', $audio->release_date->format('Y-m-d')) }}" required>
                    @error('release_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Content</button>
                    <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaTypeSelect = document.getElementById('media_type');
    const fileInputContainer = document.getElementById('file-input-container');
    
    // Update file input when media type changes
    mediaTypeSelect.addEventListener('change', function() {
        const type = this.value;
        
        fetch(`/public/admin/media/get-input-template?type=${type}`)
            .then(response => response.text())
            .then(html => {
                fileInputContainer.innerHTML = html;
                initFileInputs();
            });
    });

    // Initialize file inputs
    function initFileInputs() {
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.files && this.files.length > 1) {
                    label.textContent = `${this.files.length} files selected`;
                } else {
                    label.textContent = this.files[0]?.name || 'Choose file';
                }
            });
        });
    }
});
</script>
@endpush