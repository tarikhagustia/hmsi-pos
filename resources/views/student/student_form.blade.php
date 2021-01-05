<h6>Data Pelajar</h6>
<x-form-input
    label="KODE"
    disabled
    :value="$kode"/>
<x-form-input
    label="Nomor Identitas (NIS, NIM, NISN)"
    name="student_uid"
    :value="$student->student_uid ?? null"
    :error="$errors->first('student_uid')"/>
<x-form-input
    label="Nama"
    name="name"
    :value="$student->name ?? null"
    :error="$errors->first('name')"/>
<x-form-input
    label="Email"
    name="email"
    :value="$student->email ?? null"
    :error="$errors->first('email')"/>
<x-form-input
    label="Alamat"
    name="address"
    :value="$student->address ?? null"
    :error="$errors->first('address')"/>
<x-form-select
    label="Provinsi"
    name="province"
    :initial="false"
    :value="$student->province ?? null"
    :error="$errors->first('province')"/>
<x-form-select
    label="Kota"
    name="city_id"
    :initial="false"
    :value="$student->city_id ?? null"
    :error="$errors->first('city_id')"/>
<x-form-input
    label="Kode POS"
    name="zip_code"
    :value="$student->zip_code ?? null"
    :error="$errors->first('zip_code')"/>
<x-form-input
    label="Telepon"
    name="phone_number"
    :value="$student->phone_number ?? null"
    :error="$errors->first('phone_number')"/>

@push('javascript')
<script>
    $(document).ready(() => {
        const isEditing = parseInt('{{ request()->isEditing ? 1 : 0 }}');
        const proviceSelect = $('select[name=province]');
        const citySelect =  $('select[name=city_id]');

        proviceSelect.select2({
            data: JSON.parse('{!! json_encode(option_data_provinces()) !!}')
        });

       citySelect.select2({
            data: JSON.parse('{!! json_encode(option_data_cities()) !!}')
        });

        proviceSelect.on('select2:select', e => {
            const id = e.params.data.id
            let cities = [];

            fetch(`/json/provinces/${id}/cities`)
                .then((response) => response.json())
                .then(data => {
                    cities = data;

                    citySelect.empty();
                    citySelect.select2({
                        data: data.map(item => {
                            return {
                                id: item.city_id,
                                text: item.city_name_full,
                                province_id: item.province_id
                            };
                        })
                    })

                    @if (!is_null(old('city_id')) || request()->isEditing)
                        let value = '{{ old("city_id", isset($student) ? $student->city_id : "") }}';
                        let valueIndex = cities.findIndex(item => parseInt(item.city_id) === parseInt(value))

                        if (valueIndex < 0) {
                            value = citySelect.select2('data')[0].id;
                        }

                        citySelect
                            .val(value)
                            .trigger('change');
                    @endif
                });
        });

        @if (!is_null(old('province')) || request()->isEditing)
            const provinceId = '{{ old("province", isset($student) ? $student->city->province_id : "") }}';

            proviceSelect
                .val(provinceId)
                .trigger('change')
                .trigger({
                    type: 'select2:select',
                    params: {
                        data: { id: provinceId }
                    }
                });
        @endif
    });
</script>
@endpush
