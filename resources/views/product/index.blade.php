@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Data Produk" :searchable="true" :action="route('products.create')" :pagination="$products->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50"></th>
                            <th>SKU</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>

                                <td>
                                    <img src="{{ $product->image_url }}" width="50" height="50">
                                </td>
                                <td>{{ $product->sku }}</td>
                                <td>
                                    <div>{{ $product->name }}</div>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ currency($product->price) }}</td>
                                <td>{!! $product->status_html !!}</td>
                                <td>
                                    <x-table-view-action
                                        :edit="route('products.edit', ['product' => $product->id])"
                                        :inactive="($product->status == 'ACTIVE') ? route('products.inactive', ['product' => $product->id]) : false"
                                        :publish="($product->status == 'INACTIVE') ? route('products.publish', ['product' => $product->id]) : false"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
