<h6>Data Sekolah</h6>
<x-form-input
    label="Nama"
    name="school_name"
    :value="$student->school_name ?? null"
    :error="$errors->first('school_name')"/>
<x-form-input
    label="Alamat"
    name="school_address"
    :value="$student->school_address ?? null"
    :error="$errors->first('school_address')"/>
<x-form-select
    label="Tingkat"
    name="school_level"
    :data-sources="option_data_school_levels()"
    :value="$student->school_level ?? null"
    :error="$errors->first('school_level')"/>
<x-form-input
    label="Kelas"
    name="school_class"
    :value="$student->school_class ?? null"
    :error="$errors->first('school_class')"/>
