@extends('layouts.admin')

@section('title', 'Edit Timeline Entry')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Timeline Entry</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.timeline.update', $timeline) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $timeline->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $timeline->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="media_type">Media Type</label>
                    <select class="form-control @error('media_type') is-invalid @enderror" id="media_type" name="media_type" required>
                        <option value="">Select Media Type</option>
                        <option value="image" {{ old('media_type', $timeline->media_type) === 'image' ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ old('media_type', $timeline->media_type) === 'video' ? 'selected' : '' }}>Video</option>
                        <option value="text" {{ old('media_type', $timeline->media_type) === 'text' ? 'selected' : '' }}>Text Only</option>
                    </select>
                    @error('media_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="decade">Decade</label>
                    <input type="text" class="form-control @error('decade') is-invalid @enderror" id="decade" name="decade" value="{{ old('decade', $timeline->decade) }}" placeholder="e.g., 1950s">
                    @error('decade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" id="media_file_group">
                    <label for="media_file">Media File</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('media_file') is-invalid @enderror" id="media_file" name="media_file">
                        <label class="custom-file-label" for="media_file">Choose file</label>
                    </div>
                    @error('media_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Allowed file types: JPEG, PNG, JPG, GIF, MP4. Maximum size: 10MB
                    </small>
                </div>

                <div class="form-group" id="media_url_group">
                    <label for="media_url">Media URL</label>
                    <input type="url" class="form-control @error('media_url') is-invalid @enderror" id="media_url" name="media_url" value="{{ old('media_url', $timeline->media_url) }}" placeholder="https://example.com/media">
                    @error('media_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($timeline->media_url)
                    <div class="form-group">
                        <label>Current Media</label>
                        <div class="mt-2">
                            @if($timeline->media_type === 'image')
                                <img src="{{ $timeline->media_url }}" alt="{{ $timeline->title }}" class="img-thumbnail" style="max-height: 200px;">
                            @elseif($timeline->media_type === 'video')
                                <video controls class="img-thumbnail" style="max-height: 200px;">
                                    <source src="{{ $timeline->media_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Entry</button>
                    <a href="{{ route('admin.timeline.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaTypeSelect = document.getElementById('media_type');
    const mediaFileGroup = document.getElementById('media_file_group');
    const mediaUrlGroup = document.getElementById('media_url_group');

    function updateMediaInputs() {
        const selectedType = mediaTypeSelect.value;
        if (selectedType === 'text') {
            mediaFileGroup.style.display = 'none';
            mediaUrlGroup.style.display = 'none';
        } else {
            mediaFileGroup.style.display = 'block';
            mediaUrlGroup.style.display = 'block';
        }
    }

    mediaTypeSelect.addEventListener('change', updateMediaInputs);
    updateMediaInputs();

    // Update custom file input label
    document.getElementById('media_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Choose file';
        e.target.nextElementSibling.textContent = fileName;
    });
});
</script>
@endpush
@endsection 