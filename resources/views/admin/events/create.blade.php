@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create Event</h1>
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.events._form')
        <button type="submit" class="btn btn-success">Create Event</button>
    </form>
</div>
@endsection 
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
@endpush



