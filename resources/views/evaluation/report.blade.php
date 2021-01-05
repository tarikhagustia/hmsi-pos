@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        @include('partials.alert')
        <x-table-view :title="$evaluation->subject">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="10%" rowspan="2">No.</th>
                        <th rowspan="2">NIS</th>
                        <th rowspan="2">Nama Siswa</th>
                        <th colspan="{{$rows->first()->count()}}" class="text-center">Penilaian Ke</th>
                        <th rowspan="2" width="10%">Tingkat Kenaikan</th>

                    </tr>
                    <tr>
                    @foreach($rows->first() as $i)
                            <th>{{ $i->created_at->format('d-M-Y') }}</th>
                    @endforeach
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $key => $r)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rows->get($key)->first()->student->student_uid }}</td>
                                <td>{{ $rows->get($key)->first()->student->name }}</td>
                                @foreach($rows->get($key) as $n)
                                    <td class="text-center">{{ $n->value }}</td>
                                @endforeach
                                @php
                                    $tk = $rows->get($key)->last()->value - $rows->get($key)->first()->value;
                                @endphp
                                <td class="{{ $tk > 0 ? 'text-success' : 'text-danger' }} font-weight-bold text-center">
                                    {{ $tk }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
