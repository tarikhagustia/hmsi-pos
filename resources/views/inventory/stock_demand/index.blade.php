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
                                        @if($row->status == \App\Constants\StatusConstant::PENDING)
                                        <a class="btn btn-success btn-sm d-inline-block" href="{{ route('stock-demand.send', $row->id) }}" data-toggle="tooltip" data-placement="top" title="Kirim Permintaan Barang">
                                            <i class="fas fa-paper-plane"></i>
                                        </a>

                                        <a class="btn btn-warning btn-sm d-inline-block" href="{{ route('stock-demand.edit', $row->id) }}" data-toggle="tooltip" data-placement="top" title="Sunting">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form class="d-inline-block" action="{{ route('stock-demand.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin?')">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                    @if($row->status == \App\Constants\StatusConstant::APPROVED)
                                        <a class="btn btn-success btn-sm d-inline-block" href="{{ route('stock-demand.show', $row->id) }}" data-toggle="tooltip" data-placement="top" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endif


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
