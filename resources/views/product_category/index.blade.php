@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Data Kategori Produk" :searchable="true" :action="route('product-categories.create')" :pagination="$categories->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="300">Nama</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->desc }}</td>
                                <td>{!! $category->status_html !!}</td>
                                <td>
                                    <x-table-view-action
                                        :edit="route('product-categories.edit', ['product_category' => $category->id])"
                                        :inactive="($category->status == 'ACTIVE') ? route('product-categories.inactive', $category->id) : false"
                                        :publish="($category->status == 'INACTIVE') ? route('product-categories.publish', $category->id) : false"
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
