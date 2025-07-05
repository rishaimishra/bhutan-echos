@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Event</h1>
    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.events._form', ['event' => $event])
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
@endsection 