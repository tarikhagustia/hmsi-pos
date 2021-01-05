@extends('layouts.app')

@section('content')
    <x-main-content :title="$order->code">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Informasi Pesanan</h4>
            </div>
            <div class="card-body">
                <x-label-row label="Tanggal" :value="$order->created_at"/>
                <x-label-row label="Kode" :value="$order->code"/>
                @if ($order->hasCustomer())
                    <x-label-row label="Pelanggan" :value="$order->customer->name"/>
                @else
                    <x-label-row label="Pelanggan" value="Pelanggan"/>
                @endif
                <x-label-row label="Total" :value="currency($order->total_amount)"/>
                <x-label-row label="Status" :value="$order->status"/>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Barang</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th class="text-right" width="150">Harga</th>
                            <th class="text-center" width="50">Jumlah</th>
                            <th class="text-right" width="150">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td class="text-right">{{ currency($item->item_price) }}</td>
                                <td class="text-center">{{ $item->item_qty }}</td>
                                <td class="text-right">{{ currency($item->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-main-content>
@endsection
