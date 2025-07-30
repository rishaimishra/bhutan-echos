@extends('layouts.admin')

@section('title', isset($ebook) ? 'Edit Resource' : 'Add Resource')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($ebook) ? 'Edit Resource' : 'Add Resource' }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ isset($ebook) ? route('admin.ebooks.update', $ebook) : route('admin.ebooks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($ebook))
                            @method('PUT')
                        @endif
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $ebook->title ?? '') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="author">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $ebook->author ?? '') }}" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="file">File (PDF, ePub, or Audio)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.epub,.mp3,.wav,.aac,.ogg,.flac" {{ isset($ebook) ? '' : 'required' }}>
                            
                            @if(isset($ebook) && $ebook->file_path)
                                <div class="mt-2">
                                    @if($ebook->type === 'ebook')
                                        <!-- PDF/EPUB Preview -->
                                        <div class="embed-responsive embed-responsive-16by9" style="height: 500px;">
                                            <iframe src="{{ asset('storage/' . $ebook->file_path) }}" class="embed-responsive-item" style="width: 100%; height: 100%;"></iframe>
                                        </div>
                                        <small class="form-text text-muted">
                                            Current file: <a href="{{ asset('storage/' . $ebook->file_path) }}" target="_blank">Download</a>
                                        </small>
                                    @else
                                        <!-- Audio Player -->
                                        <div class="audio-player mt-2">
                                            <audio controls style="width: 100%">
                                                <source src="{{ asset('storage/' . $ebook->file_path) }}" type="audio/{{ $ebook->format }}">
                                                Your browser does not support the audio element.
                                            </audio>
                                            <small class="form-text text-muted">
                                                Current file: <a href="{{ asset('storage/' . $ebook->file_path) }}" target="_blank">Download</a>
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="cover_image">Cover Image </label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*" >
                            @if(isset($ebook) && $ebook->cover_image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="Cover Image" class="img-thumbnail" style="max-width: 120px;">
                                </div>
                            @endif
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">{{ isset($ebook) ? 'Update' : 'Add' }} Resource</button>
                            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .audio-player {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
    }
    .embed-responsive {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 10px;
    }
</style>
@endsection