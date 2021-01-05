@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('studies.update_branch', ['study' => $study->id]) : route('studies.store_branch') }}" method="POST">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Studi' : 'Tambah Studi' }}</h4>
                </div>
                <div class="card-body">
                    <x-form-input
                            autocomplete="off"
                            label="Nama Kelas"
                            name="class_name"
                            placeholder="Contoh: IPA 1, IPA 2"
                            :value="isset($study) ? $study->class_name : null"
                            :error="$errors->first('class_name')"/>
                    <x-form-select
                            label="Studi"
                            name="study_id"
                            :data-sources="option_data_studies(request()->isEditing)"
                            :value="isset($study) ? $study->study_id : null"
                            :error="$errors->first('study_id')"/>
                    <x-form-select
                            label="Pengajar"
                            name="teacher_id"
                            :data-sources="option_data_teachers()"
                            :value="isset($study) ? $study->teacher_id : null"
                            :error="$errors->first('teacher_id')"/>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary mr-1" href="{{ route('studies.index') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection

@push('javascript')
<script>
    $(document).ready(function () {
        new Cleave('input[name=price]', {
            numeral: true,
            numeralDecimalMark: ',', delimiter: '.',
            numeralDecimalScale: 0
        });
    });
</script>
@endpush
