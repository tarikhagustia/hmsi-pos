@extends('layouts.app')

@section('content')
    <x-main-content title="Laporan">
        <x-table-view title="Laporan Penjualan" :searchable="false">
            <div class="row">
                <div class="col-sm-4">
                    <form target="_blank" class="form" method="post" action="{{ route('report.study-sales.post') }}">
                        @csrf
                        <x-form-select label="Pilih Cabang" name="branch_id" :dataSources="option_data_branches()" null>
                        </x-form-select>
                        <x-form-select label="Pilih Jenis Laporan" name="report-type">
                            <option value="rekap">REKAP</option>
                            <option value="detail">DETAIL</option>
                        </x-form-select>
                        <div class="form-group @error('date_from') has-error @enderror">
                            <label class="control-label">Dari Tanggal</label>
                            <input type="text" class="form-control datepicker" name="date_from"/>
                            @error('date_from')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('date_to') has-error @enderror">
                            <label class="control-label">Ke Tanggal</label>
                            <input type="text" class="form-control datepicker" name="date_to"/>
                            @error('date_to')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-primary">Buat Laporan</button>
                    </form>
                </div>
            </div>
        </x-table-view>
    </x-main-content>
@endsection

@push('javascript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
