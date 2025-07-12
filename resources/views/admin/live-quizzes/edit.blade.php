@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Live Quiz</h1>
    <form action="{{ route('admin.live-quizzes.update', $liveQuiz) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="live_session_id" class="form-label">Live Session</label>
            <select name="live_session_id" id="live_session_id" class="form-control @error('live_session_id') is-invalid @enderror" required>
                <option value="">Select Live Session</option>
                @foreach($liveSessions as $session)
                    <option value="{{ $session->id }}" {{ old('live_session_id', $liveQuiz->live_session_id) == $session->id ? 'selected' : '' }}>
                        {{ $session->title }}
                    </option>
                @endforeach
            </select>
            @error('live_session_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $liveQuiz->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $liveQuiz->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $liveQuiz->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Active</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $liveQuiz->start_time ? $liveQuiz->start_time->format('Y-m-d\TH:i') : '') }}">
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $liveQuiz->end_time ? $liveQuiz->end_time->format('Y-m-d\TH:i') : '') }}">
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.live-quizzes.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Live Quiz</button>
        </div>
    </form>
</div>
@endsection 