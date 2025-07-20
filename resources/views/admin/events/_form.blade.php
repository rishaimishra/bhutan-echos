@php
    $editing = isset($event);
@endphp

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="icon" class="form-label">Icon (500x500)</label>
    @if($editing && $event->icon)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $event->icon) }}" alt="Icon" width="80" height="80">
        </div>
    @endif
    <input type="file" name="icon" id="icon" class="form-control" {{ $editing ? '' : 'required' }} accept="image/*">
</div>

<div class="mb-3">
    <label for="banner_images" class="form-label">Banner Images</label>
    @if($editing && $event->banner_images)
        <div class="mb-2">
            @foreach($event->banner_images as $img)
                <img src="{{ asset('storage/' . $img) }}" alt="Banner" width="100" class="me-2 mb-2">
            @endforeach
        </div>
    @endif
    <input type="file" name="banner_images[]" id="banner_images" class="form-control" multiple accept="image/*">
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input id="description" type="hidden" name="description" value="{{ old('description', $event->description ?? '') }}">
    <trix-editor input="description"></trix-editor>
</div>

<div class="mb-3">
    <label for="start_date" class="form-label">Start Date</label>
    <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', isset($event) ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required>
</div>

<div class="mb-3">
    <label for="end_date" class="form-label">End Date</label>
    <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', isset($event) ? $event->end_date->format('Y-m-d\TH:i') : '') }}" required>
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }}>
    <label for="is_featured" class="form-check-label">Featured Event</label>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.min.css" />
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>
@endpush 