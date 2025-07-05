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