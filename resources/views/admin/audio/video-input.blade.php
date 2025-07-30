<div class="form-group">
    <label for="media_file">Video File</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="media_file" name="media_file" accept="video/*">
        <label class="custom-file-label" for="media_file">Choose new video file (optional)</label>
    </div>
    @if(!empty($mediaUrls))
        <small class="form-text text-muted">Current file: {{ basename($mediaUrls[0]) }}</small>
        <div class="mt-2">
            <video controls class="w-100" style="max-height: 300px;">
                <source src="{{ url($mediaUrls[0]) }}" type="video/mp4">
                Your browser does not support the video element.
            </video>
        </div>
    @endif
</div>