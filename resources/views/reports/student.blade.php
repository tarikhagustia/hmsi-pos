@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        <x-table-view title="Laporan Siswa" :searchable="false">
            @livewire('student-report-table')
        </x-table-view>
    </x-main-content>
@endsection
