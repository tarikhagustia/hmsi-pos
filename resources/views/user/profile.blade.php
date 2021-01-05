@extends('layouts.app')

@section('content')
    <x-main-content title="Pengaturan">
        <div class="card">
            @include('partials.alert')
            <form action="{{ route('profile.update', $user)  }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="card-header">
                    <h4>Profil</h4>
                </div>
                <div class="card-body">
{{--                    @if(auth()->user()->hasRole('Super Admin'))--}}
{{--                        <div class="form-group">--}}
{{--                            <label>Cabang</label>--}}
{{--                            <select class="form-control{{ $errors->first('branch_id', ' is-invalid') }}" name="branch_id">--}}
{{--                                @foreach($branches as $row)--}}
{{--                                    <option value="{{$row->id}}" {{ old('branch_id', isset($user) ? ($user->branch_id == $row->id) ? 'selected' : null  : '') }}>{{$row->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            {!! $errors->first('branch_id', '<p class="invalid-feedback">:message</p>') !!}--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control{{ $errors->first('name', ' is-invalid') }}" type="text" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}">
                        {!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control{{ $errors->first('email', ' is-invalid') }}" type="email" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}" readonly>
                        {!! $errors->first('email', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input class="form-control{{ $errors->first('password', ' is-invalid') }}" type="password" name="password" value="">
                        {!! $errors->first('password', '<p class="invalid-feedback">:message</p>') !!}
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Kata Sandi</label>
                        <input class="form-control{{ $errors->first('password_confirmation', ' is-invalid') }}" type="password" name="password_confirmation" value="">
                        {!! $errors->first('password_confirmation', '<p class="invalid-feedback">:message</p>') !!}
                    </div>

                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="{{ route('home') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection
