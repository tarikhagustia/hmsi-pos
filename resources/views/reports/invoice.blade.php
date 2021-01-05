@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        <x-table-view title="Laporan Invoice" :searchable="false">
            @livewire('invoice-report-table')
        </x-table-view>
    </x-main-content>
@endsection
