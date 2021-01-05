@extends('layouts.app')

@section('content')
    <x-main-content :title="$student->name">
        <div class="card">
            <form action="{{ route('student-studies.store_payment', ['student' => $student->id, 'student_study' => $studentStudy->id]) }}" method="POST">
                @csrf
                <div class="card-header">
                    <h4>{{ 'Bayar Studi' }}</h4>
                </div>
                <div class="card-body">
                    <h6>Data Studi</h6>
                    <x-form-select
                        label="Studi"
                        name="study_id"
                        :value="$student->study_id ?? null"
                        :error="$errors->first('study')">
                        <option value="{{ $studentStudy->study->id }}">{{ $studentStudy->study->name }}</option>
                    </x-form-select>
                    <x-form-input label="Harga" :value="currency($studentStudy->total_amount, 0, null)" readonly/>
                    <x-form-input label="Telah dibayar" :value="currency($studentStudy->amount_paid, 0, null)" readonly/>
                    <x-form-input label="Pembayaran" :value="$studentStudy->study->payment_type" readonly/>
                    <x-form-input label="Pembayaran Selanjutnya" :value="$studentStudy->next_payment" readonly/>
                    <h6 class="mt-5">Data Pembayaran</h6>
                    <x-form-input
                        autocomplete="off"
                        label="Jumlah yang dibayar"
                        name="amount_paid"
                        min="0"
                        :value="$studentStudy->total_amount - $studentStudy->amount_paid"
                        :error="$errors->first('amount_paid')"/>
                    <x-form-select
                        label="Metode Pembayaran"
                        name="payment_method"
                        :errors="$errors">
                        <option value="CASH">CASH</option>
                        <option value="BANK_TRANSFER">BANK TRANSFER</option>
                    </x-form-select>
                    <x-form-input label="Nama Bank" name="payment_bank_name"/>
                    <x-form-input label="Nomor Kartu" name="payment_card_no"/>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="{{ route('student-studies.show', ['student' => $student->id, 'student_study' => $studentStudy->id]) }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection

@push('javascript')
<script>
    $(document).ready(() => {
        new Cleave('input[name=amount_paid]', {
            numeral: true,
            numeralDecimalMark: ',', delimiter: '.'
        });

        const paymentMethodSelect = $('select[name=payment_method]');
        const inputPaymentBankName = $('input[name=payment_bank_name]');
        const inputPaymentCardNumber = $('input[name=payment_card_no]');

        function checkPaymentMethod () {
            if (paymentMethodSelect.val() === 'CASH') {
                inputPaymentBankName.attr('disabled', true);
                inputPaymentCardNumber.attr('disabled', true);
            } else {
                inputPaymentBankName.attr('disabled', false);
                inputPaymentCardNumber.attr('disabled', false);
            }
        }

        checkPaymentMethod();

        paymentMethodSelect.on('select2:select', function () {
            checkPaymentMethod();
        });
    });
</script>
@endpush
