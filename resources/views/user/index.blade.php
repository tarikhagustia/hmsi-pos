@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Data Pengguna" :searchable="true" :action="auth()->user()->hasRole('Super Admin') ? route('users.create') : null" :pagination="$users->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $row)
                            <tr>
                                <td>{{ $row->branch->name ?? '-' }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->role->name ?? '-' }}</td>
                                @if($row->id != auth()->id())
                                <td>
                                    <x-table-view-action
                                        :edit="route('users.edit', $row->id)"
                                        :delete="route('users.destroy', $row->id)"/>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-table-view>
    </x-main-content>
@endsection
