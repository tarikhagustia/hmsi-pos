@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <x-table-view title="Data Cabang" :searchable="true" :action="route('branches.create')" :pagination="$branches->links()">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Nama PIC</th>
                            <th>Telepon PIC</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $branch)
                            <tr>
                                <td>{{ $branch->code }}</td>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->address }}</td>
                                <td>{{ $branch->pic_name }}</td>
                                <td>{{ $branch->pic_phone_number }}</td>
                                <td>
                                    <x-table-view-action
                                        :edit="route('branches.edit', ['branch' => $branch->id])"
{{--                                        :delete="route('branches.destroy', ['branch' => $branch->id])"--}}
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
