@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form
                action="{{ request()->isEditing ?  route('products.update', ['product' => $product->id]) : route('products.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Produk' : 'Tambah Produk' }}</h4>
                </div>
                <div class="card-body">
                    <x-form-select
                        label="Kategori"
                        name="category_id"
                        :data-sources="option_data_product_categories()"
                        :value="$product->category_id ?? null"
                        :error="$errors->first('category_id')"/>
                    <x-form-input
                        label="SKU"
                        name="sku"
                        :value="$product->sku ?? null"
                        :error="$errors->first('sku')"/>
                    <x-form-input
                        label="Nama"
                        name="name"
                        :value="$product->name ?? null"
                        :error="$errors->first('name')"/>
                    <x-form-input
                        label="Keterangan"
                        name="desc"
                        type="textarea"
                        :value="$product->desc ?? null"
                        :error="$errors->first('desc')"/>
                    <x-form-input
                            label="Harga Beli"
                            name="buy_price"
                            :value="$product->buy_price ?? null"
                            :error="$errors->first('buy_price')"/>
                    <x-form-input
                        label="Harga Jual"
                        name="price"
                        :value="$product->price ?? null"
                        :error="$errors->first('price')"/>
                    <x-form-input
                            label="Stock Awal"
                            name="stock"
                            :value="$product->stock ?? null"
                            :error="$errors->first('stock')"/>
                    <x-form-image
                        label="Gambar"
                        name="image"
                        :image-url="$product->image_url ?? null"
                        :error="$errors->first('image')"/>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary mr-1" href="{{ route('products.index') }}">Batal</a>
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
            numeralDecimalMark: ',', delimiter: '.'
        });

        new Cleave('input[name=buy_price]', {
            numeral: true,
            numeralDecimalMark: ',', delimiter: '.'
        });
    });
</script>
@endpush
