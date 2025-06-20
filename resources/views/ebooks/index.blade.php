@extends('layouts.app')

@section('title', 'E-Books Library')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">E-Books Library</h2>
    <div class="row">
        @forelse($ebooks as $ebook)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="Cover" class="img-fluid mb-2" style="max-height: 180px; object-fit: cover; width: 100%;">
                        <h5 class="card-title">{{ $ebook->title }}</h5>
                        <p class="card-text mb-1"><strong>Author:</strong> {{ $ebook->author }}</p>
                        <p class="card-text mb-2"><strong>Format:</strong> {{ strtoupper($ebook->format) }}</p>
                        <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-primary mt-auto">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No e-books available at the moment. Please check back later!
                </div>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $ebooks->links() }}
    </div>
</div>
@endsection 