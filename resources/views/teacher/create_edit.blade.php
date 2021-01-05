@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('teachers.update', ['teacher' => $teacher->id]) : route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Pengajar' : 'Tambah Pengajar' }}</h4>
                </div>
                <div class="card-body">
                    @if(auth()->user()->hasRole('Super Admin'))
                    <div class="form-group">
                        <label>Cabang</label>
                        <select class="form-control{{ $errors->first('branch_id', ' is-invalid') }}" name="branch_id">
                            @foreach($branches as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('branch_id', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    @endif
                    <div class="form-group">
                        <label>NIP</label>
                        <input class="form-control{{ $errors->first('nip', ' is-invalid') }}" type="text" name="nip" value="{{ old('nip', isset($teacher) ? $teacher->nip : '') }}">
                        {!! $errors->first('nip', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control{{ $errors->first('name', ' is-invalid') }}" type="text" name="name" value="{{ old('name', isset($teacher) ? $teacher->name : '') }}">
                        {!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control{{ $errors->first('email', ' is-invalid') }}" type="email" name="email" value="{{ old('email', isset($teacher) ? $teacher->email : '') }}">
                        {!! $errors->first('email', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input class="form-control{{ $errors->first('password', ' is-invalid') }}" type="password" name="password" value="{{ old('password') }}">
                        {!! $errors->first('password', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <select class="select2 form-control{{ $errors->first('city_id', ' is-invalid') }}" name="city_id">
                            @foreach($cities as $city)
                                <option value="{{$city->city_id}}">{{$city->city_name_full}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('city_id', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input class="form-control{{ $errors->first('address', ' is-invalid') }}" type="text" name="address" value="{{ old('address', isset($teacher) ? $teacher->address : '') }}">
                        {!! $errors->first('address', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Kode Pos</label>
                        <input class="form-control{{ $errors->first('zip_code', ' is-invalid') }}" type="number" name="zip_code" value="{{ old('zip_code', isset($teacher) ? $teacher->zip_code : '') }}">
                        {!! $errors->first('zip_code', '<p class="invalid-feedback">:message</p>') !!}
                    </div>

                    <div class="form-group">
                        <label>Nomor Telp.</label>
                        <input class="form-control{{ $errors->first('phone_number', ' is-invalid') }}" type="text" name="phone_number" value="{{ old('phone_number', isset($teacher) ? $teacher->phone_number : '') }}">
                        {!! $errors->first('phone_number', '<p class="invalid-feedback">:message</p>') !!}
                    </div>

                    <div class="form-group">
                        <label>Komentar</label>
                        <input class="form-control{{ $errors->first('comment', ' is-invalid') }}" type="text" name="comment" value="{{ old('comment', isset($teacher) ? $teacher->comment : '') }}">
                        {!! $errors->first('comment', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Avatar (opsional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input{{ $errors->first('avatar', ' is-invalid') }}" id="avatar" name="avatar">
                            <label class="custom-file-label" for="customFile">Pilih gambar (png, jpeg)</label>
                            {!! $errors->first('avatar', '<p class="invalid-feedback">:message</p>') !!}
                        </div>

                    </div>

                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="{{ route('teachers.index') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection
