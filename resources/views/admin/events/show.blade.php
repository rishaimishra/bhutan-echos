@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>{{ $event->title }}</h1>
    <div class="mb-3">
        <strong>Icon:</strong><br>
        @if($event->icon)
            <img src="{{ asset('storage/' . $event->icon) }}" alt="Icon" width="100" height="100">
        @endif
    </div>
    <div class="mb-3">
        <strong>Banner Images:</strong><br>
        @if($event->banner_images)
            @foreach($event->banner_images as $img)
                <img src="{{ asset('storage/' . $img) }}" alt="Banner" width="150" class="me-2 mb-2">
            @endforeach
        @endif
    </div>
    <div class="mb-3">
        <strong>Description:</strong><br>
        <div>{!! $event->description !!}</div>
    </div>
    <div class="mb-3">
        <strong>Start Date:</strong> {{ $event->start_date }}<br>
        <strong>End Date:</strong> {{ $event->end_date }}
    </div>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">Edit</a>
</div>
@endsection 