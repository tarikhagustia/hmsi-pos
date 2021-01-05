@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Laporan Inventory" :searchable="false" :pagination="$products->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Produk</th>
                            <th>Stok Saat Ini</th>
                            <th>Terakhir Diubah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $row)
                            <tr>
                                <td>{{ $row->branch->name ?? '-' }}</td>
                                <td>
                                    {{ $row->product->full_name }}
                                </td>
                                <td>{{ $row->qty }}</td>
                                <td>{{ $row->updated_at ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('report.inventory.show', $row) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
