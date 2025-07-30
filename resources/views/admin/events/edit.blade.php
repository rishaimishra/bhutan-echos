@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Event</h1>
    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.events._form', ['event' => $event])
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
@endsection 
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
@endpush