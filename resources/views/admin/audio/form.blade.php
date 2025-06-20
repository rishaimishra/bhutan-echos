@extends('layouts.admin')

@section('title', isset($audio) ? 'Edit Audio Clip' : 'Add Audio Clip')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
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
                            <label for="audio">Audio File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('audio') is-invalid @enderror" id="audio" name="audio" accept="audio/mp3,audio/wav" {{ !isset($audio) ? 'required' : '' }}>
                                <label class="custom-file-label" for="audio">Choose file</label>
                                @error('audio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if(isset($audio) && $audio->audio_url)
                                <small class="form-text text-muted">Current file: {{ basename($audio->audio_url) }}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="release_date">Release Date</label>
                            <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" value="{{ old('release_date', isset($audio) ? $audio->release_date->format('Y-m-d') : '') }}" required>
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ isset($audio) ? 'Update' : 'Create' }} Audio Clip</button>
                            <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update file input label with selected filename
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush 