@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert title="Error" :message="session('error')" type="danger"></x-alert>
        @endif
        <x-table-view title="Data Studi Cabang" :searchable="true" :action="route('studies.create_branch')" :pagination="$studies->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="180">Nama Kelas</th>
                            <th width="180">Pengajar</th>
                            <th width="180">Unit</th>
                            <th width="180">Level</th>
                            <th width="180">Frekuensi</th>
                            <th width="200">Harga</th>
                            <th width="200">Status</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($studies as $study)
                            <tr>
                                <td>{{ $study->class_name ?? '-' }}</td>
                                <td>{{ $study->teacher->name }}</td>
                                <td>{{ $study->study->unit }}</td>
                                <td>{{ $study->study->level }}</td>
                                <td>{{ $study->study->number_of_meeting }}</td>
                                <td>{{ currency($study->study->price) }}</td>
                                <td>{!! $study->study->status_html !!}</td>
                                <td>
                                    <x-table-view-action
                                        :edit="route('studies.edit_branch', ['study' => $study->id])"
                                    />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
