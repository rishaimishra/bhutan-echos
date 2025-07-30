<div class="form-group">
    <label for="media_file">Audio File</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="media_file" name="media_file" accept="audio/*">
        <label class="custom-file-label" for="media_file">Choose new audio file (optional)</label>
    </div>
    @if(!empty($mediaUrls))
        <small class="form-text text-muted">Current file: {{ basename($mediaUrls[0]) }}</small>
        <div class="mt-2">
            <audio controls class="w-100">
                <source src="{{ url($mediaUrls[0]) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    @endif
</div>