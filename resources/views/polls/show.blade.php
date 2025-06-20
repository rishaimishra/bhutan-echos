@extends('layouts.app')

@section('title', 'Live Poll')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">{{ $livePoll->question }}</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Session: {{ $livePoll->session->title }}<br>
                        Type: {{ $livePoll->multiple_choice ? 'Multiple Choice' : 'Single Choice' }}
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('polls.vote', $livePoll) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            @foreach($livePoll->options as $option)
                            <div class="form-check mb-2">
                                <input type="{{ $livePoll->multiple_choice ? 'checkbox' : 'radio' }}" 
                                       class="form-check-input @error('option_id') is-invalid @enderror" 
                                       name="{{ $livePoll->multiple_choice ? 'option_ids[]' : 'option_id' }}" 
                                       id="option_{{ $option->id }}" 
                                       value="{{ $option->id }}" 
                                       required>
                                <label class="form-check-label" for="option_{{ $option->id }}">
                                    {{ $option->option }}
                                </label>
                            </div>
                            @endforeach
                            @error('option_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Vote</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 