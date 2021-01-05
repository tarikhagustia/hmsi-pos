@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('evaluations.update', $evaluation) : route('evaluations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Evaluasi' : 'Tambah Evaluasi' }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Subyek</label>
                        <input class="form-control{{ $errors->first('subject', ' is-invalid') }}" type="text" name="subject" value="{{ old('subject', isset($evaluation) ? $evaluation->subject : '') }}">
                        {!! $errors->first('subject', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input class="form-control{{ $errors->first('desc', ' is-invalid') }}" type="text" name="desc" value="{{ old('desc', isset($evaluation) ? $evaluation->desc : '') }}">
                        {!! $errors->first('desc', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Tanggal Test</label>
                        <input class="form-control datepicker {{ $errors->first('test_date', ' is-invalid') }}" type="text" name="test_date" value="{{ old('test_date', isset($evaluation) ? $evaluation->test_date : '') }}">
                        {!! $errors->first('test_date', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Dokumen (opsional)</label>

                        <div class="custom-file">
                            <input type="file" class="custom-file-input{{ $errors->first('file', ' is-invalid') }}" id="file" name="file">
                            <label class="custom-file-label" for="file">Pilih file (pdf, docx)</label>
                            {!! $errors->first('file', '<p class="invalid-feedback">:message</p>') !!}
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="{{ route('evaluations.index') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection

@push('javascript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
