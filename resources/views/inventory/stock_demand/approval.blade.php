@extends('layouts.app')

@section('content')
    <x-main-content title="Inventory">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Data Permintaan Barang" :searchable="true" :action="route('stock-demand.create')" :pagination="$stockDemands->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Kode</th>
                            <th>Komentar</th>
                            <th>Tanggal Permintaan</th>
                            <th>Status</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockDemands as $row)
                            <tr>
                                <td>{{ $row->branch->name ?? '-' }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->comment }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{!! $row->status_html !!} </td>
                                <td>
                                    <div class="text-center">
                                        <a class="btn btn-success btn-sm d-inline-block" href="{{ route('stock-demand.approval_detail', $row->id) }}" data-toggle="tooltip" data-placement="top" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
