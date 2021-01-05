<h6>Data Wali</h6>
<x-form-input
    label="Nama"
    name="guardian_name"
    :value="$student->guardian_name ?? null"
    :error="$errors->first('guardian_name')"/>
<x-form-input
        label="Email (Opsional)"
        name="guardian_email"
        :value="$student->guardian_email ?? null"
        :error="$errors->first('guardian_email')"/>
<div class="form-group">
    <label class="d-block">Status</label>
    <div class="form-check form-check-inline">
        <input id="guardia_type_1" class="form-check-input{{ $errors->first('guardian_type', ' is-invalid') }}" type="radio" name="guardian_type" value="AYAH"{{ old('guardian_type', 'AYAH') == 'AYAH' || (isset($student) &&  $student->guardian_type == 'AYAH') ? ' checked' : '' }}>
        <label class="form-check-label" for="guardia_type_1">Ayah</label>
    </div>
    <div class="form-check form-check-inline">
        <input id="guardia_type_2" class="form-check-input{{ $errors->first('guardian_type', ' is-invalid') }}" type="radio" name="guardian_type" value="IBU"{{ old('guardian_type') == 'IBU' || (isset($student) &&  $student->guardian_type == 'IBU') ? ' checked' : '' }}>
        <label class="form-check-label" for="guardia_type_2">Ibu</label>
    </div>
    <div class="form-check form-check-inline">
        <input id="guardia_type_3" class="form-check-input{{ $errors->first('guardian_type', ' is-invalid') }}" type="radio" name="guardian_type" value="LAINNYA"{{ old('guardian_type') == 'LAINNYA' || (isset($student) &&  $student->guardian_type == 'LAINNYA') ? ' checked' : '' }}>
        <label class="form-check-label" for="guardia_type_3">Lainnya</label>
    </div>
    {!! $errors->first('guardian_type', '<p class="invalid-feedback">:message</p>') !!}
</div>
<x-form-input
    label="Telepon"
    name="guardian_phone_number"
    :value="$student->guardian_phone_number ?? null"
    :error="$errors->first('guardian_phone_number')"/>
<x-form-input
    label="Alamat"
    name="guardian_address"
    :value="$student->guardian_address ?? null"
    :error="$errors->first('guardian_address')"/>
<x-form-select
    label="Pekerjaan"
    name="guardian_job"
    :initial="false"
    :tags="true"
    :value="$student->guardian_job ?? null"
    :error="$errors->first('guardian_job')"/>


@push('javascript')
<script>
    $(document).ready(() => {
        const jobSelect = $('select[name=guardian_job]');

        jobSelect.select2({
            data: JSON.parse('{!! json_encode(option_data_jobs()) !!}').map(item => {
                return { id: item.text, text: item.text };
            }),
            tags: true
        });

        @if (!is_null(old('guardian_job')) || request()->isEditing)
            jobSelect
                .val('{{ old("guardian_job", isset($student) ? $student->guardian_job : "") }}')
                .trigger('change');
        @endif
    });
</script>
@endpush
