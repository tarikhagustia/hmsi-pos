@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Tagihan">
            @livewire('invoice-table')
        </x-table-view>
    </x-main-content>
@endsection
