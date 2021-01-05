@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        <x-table-view :title="'Laporan Perubahan Stock - '.$product->product->name" :searchable="false">
            @livewire('inventory-movement-table', ['product' => $product->id])
        </x-table-view>
    </x-main-content>
@endsection
