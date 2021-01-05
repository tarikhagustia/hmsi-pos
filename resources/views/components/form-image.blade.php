<div class="form-group{{ $error ? ' has-error' : '' }}">
    <label>{{ $label }}</label>
    <div>
        <input class="{{ $error ? 'is-invalid' : '' }}" type="file" name="{{ $name }}">
        @if ($error)
            <p class="invalid-feedback">{{ $error }}</p>
        @endif
    </div>
</div>
@if (request()->isEditing)
    <div class="form-group">
        <label>{{ $labelCurrent }}</label>
        <div>
            <img src="{{ $imageUrl }}" width="320">
        </div>
    </div>
@endif
