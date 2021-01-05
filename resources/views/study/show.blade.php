@extends('layouts.app')

@section('content')
    <x-main-content title="Studi">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Informasi Studi</h4>
                <div class="card-header-action">
                    <a class="btn btn-primary" href="{{ route('studies.edit', ['study' => $study->id]) }}">Sunting</a>
                </div>
            </div>
            <div class="card-body">
                <x-label-row label="Nama" :value="$study->name"/>
                <x-label-row label="Unit" :value="$study->unit"/>
                <x-label-row label="Level" :value="$study->level"/>
                <x-label-row label="Harga" :value="currency($study->price)"/>
                <x-label-row label="Keterangan" :value="$study->desc"/>
                <x-label-row label="Frekuensi" :value="$study->number_of_meeting.'x'"/>
                <x-label-row label="Pembayaran" :value="$study->payment_type"/>
            </div>
        </div>
    </x-main-content>
@endsection
