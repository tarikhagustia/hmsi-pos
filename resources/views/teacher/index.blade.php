@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @include('partials.alert')
        <x-table-view title="Data Pengajar" :searchable="true" :action="route('teachers.create')" :pagination="$teachers->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>Cabang</th>
                            <th>Alamat</th>
                            <th>Nomor Telp</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td>
                                    <img src="{{$teacher->avatar_url}}" class="img-fluid rounded-circle author-box-picture" width="50" alt="{{$teacher->name}}">
                                </td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->branch->name }}</td>
                                <td>{{ $teacher->address }}</td>
                                <td>{{ $teacher->phone_number }}</td>
                                <td>
                                    <x-table-view-action
                                        :edit="route('teachers.edit', ['teacher' => $teacher->id])"
                                        :delete="route('teachers.destroy', ['teacher' => $teacher->id])"/>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
