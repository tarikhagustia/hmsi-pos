@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        @include('partials.alert')
        <x-table-view :title="$evaluation->subject">
            <form action="{{route('evaluations.evaluate.store', $evaluation)}}" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="10%">No.</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>

                            @if($evaluation->evaluations->count() > 0)
                                <th width="10%">Nilai Sebelumnya</th>
                            @endif
                            <th>Komentar</th>
                            <th width="10%">Nilai</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($students as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->student_uid }}
                                    <input type="hidden" name="students[]" value="{{$s->id}}">
                                </td>
                                <td>{{ $s->name }}</td>
                                @if($n = $evaluation->evaluations->where('student_id', $s->id))
                                    @if($n->count() > 0)
                                        <th width="10%">{{ $n->last()->value }}</th>
                                    @endif
                                @endif
                                <td>
                                    <input class="form-control" type="text" value="" name="comment[]" required>
                                </td>

                                <td>
                                    <input class="form-control" type="number" value="0" name="value[]">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Anda belum mempunyai siswa</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </form>
        </x-table-view>
    </x-main-content>
@endsection
