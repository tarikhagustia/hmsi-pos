@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Data Studi (Paket)" :searchable="true" :action="route('studies-bundle.create')" :pagination="$studies->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Nama</th>
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
                            <td>{{ $study->name }}</td>
                            <td>{{ $study->unit }}</td>
                            <td>{{ $study->level }}</td>
                            <td>{{ $study->number_of_meeting }}x</td>
                            <td>{{ currency($study->price) }}</td>
                            <td>{!! $study->status_html !!}</td>
                            <td>
                                <x-table-view-action
                                        :show="route('studies-bundle.show', ['study' => $study->id])"
                                        :edit="route('studies-bundle.edit', ['study' => $study->id])"
                                        :delete="route('studies-bundle.destroy', ['study' => $study->id])"
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
