@extends('layouts.admin')

@section('title', isset($ebook) ? 'Edit E-Book' : 'Add E-Book')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($ebook) ? 'Edit E-Book' : 'Add E-Book' }}</h3>
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
                            <label for="file">E-Book File (PDF or ePub)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.epub" {{ isset($ebook) ? '' : 'required' }}>
                            @if(isset($ebook) && $ebook->file_path)
                                <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $ebook->file_path) }}" target="_blank">Download</a></small>
                            @endif
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="cover_image">Cover Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*" required>
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
                            <button type="submit" class="btn btn-primary">{{ isset($ebook) ? 'Update' : 'Add' }} E-Book</button>
                            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 