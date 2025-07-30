@extends('layouts.admin')

@section('title', 'Add Content')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Content</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.audio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="media_type">Content Type</label>
                    <select class="form-control @error('media_type') is-invalid @enderror" id="media_type" name="media_type" required>
                        <option value="">Select Type</option>
                        <option value="text" {{ old('media_type') == 'text' ? 'selected' : '' }}>Text Only</option>
                        <option value="audio" {{ old('media_type') == 'audio' ? 'selected' : '' }}>Audio</option>
                        <option value="video" {{ old('media_type') == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="image" {{ old('media_type') == 'image' ? 'selected' : '' }}>Image</option>
                    </select>
                    @error('media_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div id="file-input-container">
                    <!-- Dynamic file inputs will be inserted here -->
                </div>

                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" value="{{ old('release_date') }}" required>
                    @error('release_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Content</button>
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
    
    // File input templates
    const templates = {
        audio: `
            <div class="form-group">
                <label for="media_file">Audio File</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="media_file" name="media_file" accept="audio/*" required>
                    <label class="custom-file-label" for="media_file">Choose audio file</label>
                </div>
                <small class="form-text text-muted">Allowed: MP3, WAV (Max 10MB)</small>
            </div>
        `,
        video: `
            <div class="form-group">
                <label for="media_file">Video File</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="media_file" name="media_file" accept="video/*" required>
                    <label class="custom-file-label" for="media_file">Choose video file</label>
                </div>
                <small class="form-text text-muted">Allowed: MP4, MOV, AVI (Max 10MB)</small>
            </div>
        `,
        image: `
            <div class="form-group">
                <label for="media_files">Image Files</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="media_files" name="media_files[]" multiple accept="image/*" required>
                    <label class="custom-file-label" for="media_files">Choose image files</label>
                </div>
                <small class="form-text text-muted">Allowed: JPG, PNG, GIF (Max 10MB each)</small>
            </div>
        `
    };

    // Update file input when media type changes
    mediaTypeSelect.addEventListener('change', function() {
        const type = this.value;
        fileInputContainer.innerHTML = '';
        
        if (type === 'audio' || type === 'video' || type === 'image') {
            fileInputContainer.innerHTML = templates[type];
            initFileInputs();
        }
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

    // Initialize on page load if there's a selected type
    if (mediaTypeSelect.value && mediaTypeSelect.value !== 'text') {
        mediaTypeSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush