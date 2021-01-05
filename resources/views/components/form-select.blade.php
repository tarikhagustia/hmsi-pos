<div class="form-group{{ $error ? ' has-error' : '' }}">
    <label>{{ $label }}</label>
    <select
        class="form-control{{ $error ? ' is-invalid' : '' }}"
        name="{{ $name }}"
        {{ $attributes }}>
        {{ $slot }}
    </select>
    @if ($error)
        <p class="invalid-feedback">{{ $error }}</p>
    @endif
</div>
@if ($initial)
    @push('javascript')
    <script>
        $(document).ready(() => {
            @if ($attributes['id'])
                const select = $('#{{ $attributes["id"] }}');
            @else
                const select = $('select[name={{ $name }}]');
            @endif

            @if ($dataSources)
                select.select2({
                    data: JSON.parse('{!! json_encode($dataSources) !!}'),
                    tags: {{ json_encode($tags) }}
                });
            @else
                select.select2()
            @endif

            @if ($triggerChange)
                @if (!is_null(old($name)) || request()->isEditing)
                    @if (is_array($value))
                        select
                            .val(JSON.parse('{!! json_encode(old($name, $value ?? [])) !!}'))
                            .trigger('change');
                    @else
                        select
                            .val('{{ old($name, $value ?? "") }}')
                            .trigger('change');
                    @endif
                @endif
            @endif
        });
    </script>
    @endpush
@endif
