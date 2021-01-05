@extends('layouts.app')

@section('content')
    <x-main-content :title="'Tagihan | '.$invoice->code">
        @include('partials.alert')
        <div class="card">
            <div class="card-header">
                <h4>Informasi Tagihan</h4>
            </div>
            <div class="card-body">
                <x-label-row label="Nomor" :value="$invoice->code"/>
                <x-label-row label="Tanggal" :value="$invoice->date->format('d-m-Y')"/>
                <x-label-row label="Jatuh Tempo" :value="$invoice->due_date->format('d-m-Y')"/>
                <x-label-row label="Jumlah" :value="currency($invoice->amount)"/>
                <x-label-row label="Status" :value="$invoice->status"/>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Informasi Pelajar</h4>
            </div>
            <div class="card-body">
                <x-label-row label="Branch" :value="$student->branch->name"/>
                <x-label-row label="Nomor Identitas (NIS, NIM, NISN)" :value="$student->student_uid"/>
                <x-label-row label="Nama" :value="$student->name"/>
                <x-label-row label="Email" :value="$student->email"/>
                <x-label-row label="Alamat" :value="$student->address"/>
                <x-label-row label="Provinsi" :value="$student->city->province->province_name"/>
                <x-label-row label="Kota" :value="$student->city->city_name_full"/>
                <x-label-row label="Telepon" :value="$student->phone_number"/>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Informasi Studi</h4>
            </div>
            <div class="card-body">
                <x-label-row label="Nama" :value="$study->name"/>
                <x-label-row label="Keterangan" :value="$study->desc"/>
                <x-label-row label="Harga" :value="currency($study->price)"/>
                <x-label-row label="Jumlah pertemuan (per minggu)" :value="$study->number_of_meeting.'x'"/>
                <x-label-row label="Pembayaran" :value="$study->payment_type"/>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Informasi Pembayaran</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Nomor Pembayaran</td>
                        <td>Tanggal Pembayaran</td>
                        <td>Jumlah Dibayar</td>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($invoice->payments as $p)
                        <tr>
                            <td>{{ $p->code }}</td>
                            <td>{{ $p->created_at }}</td>
                            <td>{{ currency($p->amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada pembayaran untuk invoice ini</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-main-content>
@endsection
