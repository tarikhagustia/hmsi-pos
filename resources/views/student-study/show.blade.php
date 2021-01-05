@extends('layouts.app')

@section('content')
    <x-main-content :title="$student->name">
        @if (session()->has('success'))
            <x-alert :message="session('success')"></x-alert>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Informasi Studi</h4>
            </div>
            <div class="card-body">
                @if (is_null($studentStudy->study->category_id))
{{--                    <x-label-row label="Cabang" :value="$studentStudy->study->branch->name"/>--}}
{{--                    <x-label-row label="Mata pelajaran" :value="$studentStudy->study->category->name"/>--}}
{{--                    <x-label-row label="Tingkat" :value="$studentStudy->study->level"/>--}}
                    <x-label-row label="Nama" :value="$studentStudy->study->name"/>
                    <x-label-row label="Harga" :value="currency($studentStudy->study->price)"/>
                    <x-label-row label="Keterangan" :value="$studentStudy->study->desc"/>
                    <x-label-row label="Jumlah pertemuan" :value="$studentStudy->study->number_of_meeting"/>
{{--                    <x-label-row label="Pengajar" :value="$studentStudy->study->teacher->name"/>--}}
                    <x-label-row label="Pembayaran" :value="$studentStudy->study->payment_type"/>
{{--                    <x-label-row label="Lama Cicilan (Bulan)" :value="$studentStudy->study->recurring_times ?? '-'"/>--}}
                @else
                    <x-label-row label="Cabang" :value="$studentStudy->study->branch->name"/>
                    <x-label-row label="Cabang" :value="$studentStudy->study->studies->pluck('category_name')->implode(', ')"/>
                    <x-label-row label="Nama" :value="$studentStudy->study->name"/>
                    <x-label-row label="Harga" :value="currency($studentStudy->study->price)"/>
                    <x-label-row label="Keterangan" :value="$studentStudy->study->desc"/>
                    <x-label-row label="Pembayaran" :value="$studentStudy->study->payment_type"/>
                    <x-label-row label="Lama Cicilan (Bulan)" :value="$studentStudy->study->recurring_times ?? '-'"/>
                @endif
                <x-label-row label="Status Pembayaran" :value="$studentStudy->payment_status"/>
                <x-label-row label="Pembayaran Selanjutnya" :value="$studentStudy->next_payment ?? '-'"/>
            </div>
        </div>

{{--        <x-table-view title="Data Pembayaran" :action="null">--}}
{{--                <div class="table-responsive">--}}
{{--                    <table class="table table-bordered">--}}
{{--                        <thead>--}}
{{--                            <tr>--}}
{{--                                <th>Nomor Pembayaran</th>--}}
{{--                                <th>Tanggal Pembayaran</th>--}}
{{--                                <th>Jumlah</th>--}}
{{--                                <th>Metode Pembayaran</th>--}}
{{--                                <th width="50"></th>--}}
{{--                            </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                            @foreach ($studentStudy->payments as $payment)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $payment->payment_number }}</td>--}}
{{--                                    <td>{{ $payment->payment_date }}</td>--}}
{{--                                    <td>{{ currency($payment->amount) }}</td>--}}
{{--                                    <td>{{ $payment->payment_method }}</td>--}}
{{--                                    <td class="text-center">--}}
{{--                                        <a class="btn btn-primary btn-sm d-inline-block btn-print" href="#" data-toggle="tooltip" data-payment="{{ $payment->id }}" title="Cetak">--}}
{{--                                            <i class="fas fa-print"></i>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            <a class="btn btn-success mr-2" href="{{ route('student-studies.reminder', ['student' => $student->id, 'student_study' => $studentStudy->id]) }}">Ingatkan Pembayaran (Via Email)</a>--}}
{{--            <br>--}}
{{--        </x-table-view>--}}
    </x-main-content>
@endsection

@push('javascript')
<script>
    $(document).ready(function () {
        $('.btn-print').on('click', function (e) {
            const el = $(this);

            const features = 'width=200,height=500,location=no,toolbar=no,menubar=no';
            const printWindow = window.open(`{{ url('admin') }}/print?payment=${el.data('payment')}`, '', features);

            printWindow.onload = function () {
                printWindow.focus();

                setTimeout(function () {
                    printWindow.print();
                }, 100);

                setTimeout(function () {
                    printWindow.close();
                }, 100);
            };
        });
    });
</script>
@endpush
