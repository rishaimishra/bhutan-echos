@extends('layouts.admin')

@section('title', 'E-Books Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">E-Books</h3>
                    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add E-Book
                    </a>
                </div>
                <div class="card-body">
                    @if($ebooks->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Format</th>
                                        <th>Cover</th>
                                        <th>File</th>
                                        <th>Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ebooks as $ebook)
                                        <tr>
                                            <td>{{ $ebook->title }}</td>
                                            <td>{{ $ebook->author }}</td>
                                            <td>{{ strtoupper($ebook->format) }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="Cover" class="img-thumbnail" style="max-width: 60px;">
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $ebook->file_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
                                            <td>{{ $ebook->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.ebooks.edit', $ebook) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.ebooks.destroy', $ebook) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this e-book?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $ebooks->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center mb-0">
                            No e-books found. Click "Add E-Book" to upload your first e-book.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 