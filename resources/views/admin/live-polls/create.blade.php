@extends('layouts.admin')

@section('title', 'Create Live Poll')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Poll</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.live-polls.store') }}" method="POST" id="pollForm">
                        @csrf
                        <div class="mb-3">
                            <label for="session_id" class="form-label">Live Session</label>
                            <select class="form-select @error('session_id') is-invalid @enderror" id="session_id" name="session_id" required>
                                <option value="">Select a session</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}" {{ old('session_id') == $session->id ? 'selected' : '' }}>
                                        {{ $session->title }} ({{ $session->start_time->format('M d, Y H:i') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('session_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question" value="{{ old('question') }}" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('multiple_choice') is-invalid @enderror" id="multiple_choice" name="multiple_choice" value="1" {{ old('multiple_choice') ? 'checked' : '' }}>
                                <label class="form-check-label" for="multiple_choice">Allow multiple choice</label>
                                @error('multiple_choice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Options</label>
                            <div id="options-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="options[]" required>
                                    <button type="button" class="btn btn-danger remove-option" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="options[]" required>
                                    <button type="button" class="btn btn-danger remove-option" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="add-option">
                                <i class="fas fa-plus"></i> Add Option
                            </button>
                            @error('options')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.live-polls.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Poll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const optionsContainer = document.getElementById('options-container');
    const addOptionBtn = document.getElementById('add-option');
    const removeButtons = document.querySelectorAll('.remove-option');

    // Show remove buttons if there are more than 2 options
    if (optionsContainer.children.length > 2) {
        removeButtons.forEach(btn => btn.style.display = 'block');
    }

    addOptionBtn.addEventListener('click', function() {
        const optionGroup = document.createElement('div');
        optionGroup.className = 'input-group mb-2';
        optionGroup.innerHTML = `
            <input type="text" class="form-control" name="options[]" required>
            <button type="button" class="btn btn-danger remove-option">
                <i class="fas fa-times"></i>
            </button>
        `;
        optionsContainer.appendChild(optionGroup);

        // Show remove buttons if there are more than 2 options
        if (optionsContainer.children.length > 2) {
            document.querySelectorAll('.remove-option').forEach(btn => btn.style.display = 'block');
        }

        // Add event listener to new remove button
        optionGroup.querySelector('.remove-option').addEventListener('click', function() {
            optionGroup.remove();
            // Hide remove buttons if there are only 2 options left
            if (optionsContainer.children.length <= 2) {
                document.querySelectorAll('.remove-option').forEach(btn => btn.style.display = 'none');
            }
        });
    });

    // Add event listeners to existing remove buttons
    removeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentElement.remove();
            // Hide remove buttons if there are only 2 options left
            if (optionsContainer.children.length <= 2) {
                document.querySelectorAll('.remove-option').forEach(btn => btn.style.display = 'none');
            }
        });
    });
});
</script>
@endpush
@endsection 