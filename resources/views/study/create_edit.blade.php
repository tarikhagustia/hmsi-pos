@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('studies.update', ['study' => $study->id]) : route('studies.store') }}" method="POST">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Studi' : 'Tambah Studi' }}</h4>
                </div>
                <div class="card-body">
                    <x-form-input
                        label="Unit"
                        name="unit"
                        :value="$study->unit ?? null"
                        :error="$errors->first('unit')"/>
                    <x-form-input
                            label="Level"
                            name="level"
                            :value="$study->level ?? null"
                            :error="$errors->first('level')"/>
                    <x-form-input
                            label="Frekuensi"
                            name="number_of_meeting"
                            type="number"
                            :value="$study->number_of_meeting ?? null"
                            :error="$errors->first('number_of_meeting')"/>
                    <x-form-input
                        label="Keterangan"
                        name="desc"
                        type="textarea"
                        :value="$study->desc ?? null"
                        :error="$errors->first('desc')"/>
                    <x-form-input
                        label="Harga"
                        name="price"
                        :value="$study->price ?? null"
                        :error="$errors->first('price')"/>
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
