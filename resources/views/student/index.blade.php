@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Data Pelajar" :searchable="true" :action="route('students.create')" :pagination="$students->links()">
            <div class="table-responsive-xs">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>KODE</th>
                            <th>Nama</th>
                            <th>Tingkat</th>
                            <th>Kelas</th>
                            <th width="20%">Sekolah</th>
                            <th>Status</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ sprintf("%08d", $student->id) }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->school_level }}</td>
                                <td>{{ $student->school_class }}</td>
                                <td>{{ $student->school_name }}</td>
                                <td>{!! $student->status_html !!}</td>
                                <td>
                                    <x-table-view-action
                                        :show="route('students.show', ['student' => $student->id])"
                                        :edit="route('students.edit', ['student' => $student->id])"
{{--                                        :delete="route('students.destroy', ['student' => $student->id])"--}}
                                        :inactive="($student->status == 'ACTIVE') ? route('students.inactive', $student->id) : false"
                                        :publish="($student->status == 'INACTIVE') ? route('students.publish', $student->id) : false"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
