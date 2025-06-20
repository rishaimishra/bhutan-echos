@extends('layouts.admin')

@section('title', isset($audio) ? 'Edit Audio Clip' : 'Add Audio Clip')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ isset($audio) ? 'Edit Audio Clip' : 'Add Audio Clip' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ isset($audio) ? route('admin.audio.update', $audio) : route('admin.audio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($audio))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $audio->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" value="{{ old('release_date', isset($audio) ? $audio->release_date->format('Y-m-d') : '') }}" required>
                    @error('release_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="audio_file">Audio File</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('audio_file') is-invalid @enderror" id="audio_file" name="audio_file" {{ !isset($audio) ? 'required' : '' }}>
                        <label class="custom-file-label" for="audio_file">Choose file</label>
                    </div>
                    @error('audio_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Allowed file types: MP3, WAV. Maximum size: 10MB
                    </small>
                </div>

                @if(isset($audio) && $audio->audio_url)
                    <div class="form-group">
                        <label>Current Audio</label>
                        <div class="mt-2">
                            <audio controls class="w-100">
                                <source src="{{ $audio->audio_url }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($audio) ? 'Update Audio' : 'Add Audio' }}
                    </button>
                    <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update custom file input label
    document.getElementById('audio_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Choose file';
        e.target.nextElementSibling.textContent = fileName;
    });
});
</script>
@endpush
@endsection 