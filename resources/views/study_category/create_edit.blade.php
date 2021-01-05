@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('study-categories.update', ['study_category' => $studyCategory->id]) : route('study-categories.store') }}" method="POST">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Mata Pelajaran' : 'Tambah Mata Pelajaran' }}</h4>
                </div>
                <div class="card-body">
                    <x-form-input
                        label="Nama"
                        name="name"
                        :value="$theory->name ?? null"
                        :error="$errors->first('name')"/>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary mr-1" href="{{ route('study-categories.index') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection