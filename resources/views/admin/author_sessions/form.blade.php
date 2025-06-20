@extends('layouts.admin')

@section('title', isset($author_session) ? 'Edit Author Session' : 'Schedule Author Session')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($author_session) ? 'Edit Author Session' : 'Schedule Author Session' }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ isset($author_session) ? route('admin.author-sessions.update', $author_session) : route('admin.author-sessions.store') }}" method="POST">
                        @csrf
                        @if(isset($author_session))
                            @method('PUT')
                        @endif
                        <div class="form-group mb-3">
                            <label for="author_name">Author Name</label>
                            <input type="text" class="form-control @error('author_name') is-invalid @enderror" id="author_name" name="author_name" value="{{ old('author_name', $author_session->author_name ?? '') }}" required>
                            @error('author_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="bio">Author Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $author_session->bio ?? '') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="start_time">Start Time</label>
                            <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', isset($author_session) ? $author_session->start_time->format('Y-m-d\TH:i') : '') }}" required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="end_time">End Time</label>
                            <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', isset($author_session) ? $author_session->end_time->format('Y-m-d\TH:i') : '') }}" required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="is_active">Active</label>
                            <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $author_session->is_active ?? 1) == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_active', $author_session->is_active ?? 1) == 0 ? 'selected' : '' }}>No</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">{{ isset($author_session) ? 'Update' : 'Schedule' }} Session</button>
                            <a href="{{ route('admin.author-sessions.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 