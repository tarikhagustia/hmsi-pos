@extends('layouts.app')

@section('content')
    <x-main-content title="Studi">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('theories.update', ['study' => $study->id, 'theory' => $theory->id]) : route('theories.store', ['study' => $study->id]) }}" method="POST">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Teori' : 'Tambah Teori' }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Studi</label>
                        <input class="form-control{{ $errors->first('study_id', ' is-invalid') }}" value="{{ $study->name }}" readonly>
                        <input type="hidden" name="study_id" value="{{ $study->id }}">
                        {!! $errors->first('study_id', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <x-form-input
                        label="Judul"
                        name="subject"
                        :value="$theory->subject ?? null"
                        :error="$errors->first('subject')"/>
                    <x-form-input
                        label="Keterangan"
                        name="desc"
                        type="textarea"
                        :value="$theory->desc ?? null"
                        :error="$errors->first('desc')"/>
                    <x-form-input
                        label="Jumlah Jam"
                        name="hours"
                        type="number"
                        :value="$theory->hours ?? null"
                        :error="$errors->first('hours')"/>
                    <x-form-input
                        label="Nilai Awal"
                        name="initial_value"
                        type="number"
                        :value="$theory->initial_value ?? null"
                        :error="$errors->first('initial_value')"/>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary mr-1" href="{{ route('studies.show', ['study' => $study->id]) }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection