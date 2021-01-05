@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        @include('partials.alert')
        <x-table-view title="Data Evaluasi Siswa" :searchable="true" :action="route('evaluations.create')" :pagination="$evaluations->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <th>Subyek</th>
                            <th>Jumlah Evaluasi</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $e)
                            <tr>
                                <td>{{ $e->created_at->format('Y-m-d') }}</td>
                                <td>{{ $e->subject }}</td>
                                <td>{{ $e->evaluations_count }}</td>
                                <td class="text-center">
                                        <a class="btn btn-info btn-sm d-inline-block" href="{{ route('evaluations.evaluate', $e) }}" data-toggle="tooltip" data-placement="top" title="Evaluasi Kembali">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-success btn-sm d-inline-block" href="{{ route('evaluations.report', $e) }}" data-toggle="tooltip" data-placement="top" title="Lihat Laporan">
                                            <i class="fas fa-file"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm d-inline-block" href="{{ route('evaluations.edit', $e) }}" data-toggle="tooltip" data-placement="top" title="Sunting">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form class="d-inline-block" action="{{ route('evaluations.destroy', $e) }}" method="POST" onsubmit="return confirm('Apakah anda yakin?')">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
