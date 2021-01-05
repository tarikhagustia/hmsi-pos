<div class="form-group{{ $error ? ' has-error' : '' }}">
    <label>{{ $label }}</label>
    @if ($type == 'textarea')
        <textarea
            class="form-control{{ $error ? ' is-invalid' : '' }}"
            name="{{ $name }}"
            style="height: 100px;"
            {{ $attributes }}>{{ $name ? old($name, $value ?? '') : '' }}</textarea>
    @else
        <input
            class="form-control{{ $error ? ' is-invalid' : '' }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ in_array($type, ['password']) ? '' : ($name ? old($name, $value ?? '') : $value) }}"
            {{ $attributes }}>
    @endif
    @if ($error)
        <p class="invalid-feedback">{{ $error }}</p>
    @endif
</div>
