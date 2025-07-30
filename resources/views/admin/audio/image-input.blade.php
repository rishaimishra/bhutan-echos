<div class="form-group">
    <label for="media_files">Image Files</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="media_files" name="media_files[]" multiple accept="image/*">
        <label class="custom-file-label" for="media_files">Choose new image files (optional)</label>
    </div>
    @if(!empty($mediaUrls))
        <small class="form-text text-muted">{{ count($mediaUrls) }} current images</small>
        <div class="mt-2 row">
            @foreach($mediaUrls as $url)
                <div class="col-md-3 mb-3">
                    <img src="{{ url($url) }}" class="img-thumbnail" style="max-height: 150px;">
                </div>
            @endforeach
        </div>
    @endif
</div>