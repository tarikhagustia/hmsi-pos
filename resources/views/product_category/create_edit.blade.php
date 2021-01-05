@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('product-categories.update', ['product_category' => $productCategory->id]) : route('product-categories.store') }}" method="POST">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Kategori Produk' : 'Tambah Kategori Produk' }}</h4>
                </div>
                <div class="card-body">
                    <x-form-input
                        label="Nama"
                        name="name"
                        :value="$productCategory->name ?? null"
                        :error="$errors->first('name')"/>
                    <x-form-input
                        label="Keterangan"
                        name="desc"
                        type="textarea"
                        :value="$productCategory->desc ?? null"
                        :error="$errors->first('desc')"/>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary mr-1" href="{{ route('product-categories.index') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection