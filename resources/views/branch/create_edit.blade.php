@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('branches.update', ['branch' => $branch->id]) : route('branches.store') }}" method="POST">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Cabang' : 'Tambah Cabang' }}</h4>
                </div>
                <div class="card-body">
                    <x-form-input
                            label="Kode"
                            name="code"
                            :value="$branch->code ?? null"
                            :error="$errors->first('code')"/>
                    <x-form-input
                        label="Nama"
                        name="name"
                        :value="$branch->name ?? null"
                        :error="$errors->first('name')"/>
                    <x-form-input
                        label="Alamat"
                        name="address"
                        :value="$branch->address ?? null"
                        :error="$errors->first('address')"/>
                    <x-form-input
                        label="Nama PIC"
                        name="pic_name"
                        :value="$branch->pic_name ?? null"
                        :error="$errors->first('pic_name')"/>
                    <x-form-input
                        label="Telepon PIC"
                        name="pic_phone_number"
                        :value="$branch->pic_phone_number ?? null"
                        :error="$errors->first('pic_phone_number')"/>
                    @if (request()->isEditing)
                        <x-form-select
                            label="Admin"
                            name="admin"
                            :data-sources="option_data_branch_admins($branch->admin->id)"
                            :value="$branch->admin->id ?? null"
                            :error="$errors->first('admin')"/>
                    @else
                        <h6>Data Admin</h6>
                        <x-form-input
                            label="Nama"
                            name="admin_name"
                            :error="$errors->first('admin_name')"/>
                        <x-form-input
                            label="Email"
                            name="admin_email"
                            type="email"
                            :error="$errors->first('admin_email')"/>
                        <x-form-input
                            label="Kata Sandi"
                            name="admin_password"
                            type="password"
                            :error="$errors->first('admin_password')"/>
                        <x-form-input
                            label="Konfirmasi Kata Sandi"
                            name="admin_password_confirmation"
                            type="password"/>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary mr-1" href="{{ route('branches.index') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection
