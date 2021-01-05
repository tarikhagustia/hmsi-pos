@extends('layouts.app')

@section('content')
    <x-main-content :title="'Bayar Tagihan | '.$invoice->code">
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
                <h4>Formulir Pembayaran</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('invoices.pay', ['invoice' => $invoice->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-form-input
                        autocomplete="off"
                        label="Jumlah yang dibayar"
                        name="amount"
                        min="0"
                        :value="number_format($invoice->amount - $invoice->payments->sum('amount'), 0, '', '')"
                        :error="$errors->first('amount')"/>
                    <x-form-select
                        label="Metode Pembayaran"
                        name="payment_method"
                        :error="$errors->first('payment_method')">
                        <option value="CASH">CASH</option>
                        <option value="DEBIT">Debit Card</option>
                        <option value="CREDIT">Credit Card</option>
                        <option value="BANK_TRANSFER">Bank Transfer</option>
                    </x-form-select>
                    <x-form-input label="Nama Bank" name="payment_bank_name"/>
                    <x-form-input label="Nomor Kartu" name="payment_card_no"/>
                    <x-form-image
                            label="Bukti Transfer (Opsional)"
                            name="payment_attachment"
                            :error="$errors->first('pay_attachment')"/>
                    <div class="card-footer text-right">
                        <a class="btn btn-secondary mr-1" href="{{ route('invoices.index') }}">Batal</a>
                        <button class="btn btn-primary">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </x-main-content>
@endsection

@push('javascript')
<script>
    $(document).ready(() => {
        new Cleave('input[name=amount]', {
            numeral: true,
            numeralDecimalMark: ',', delimiter: '.',
            numeralDecimalScale: 0
        });

        const paymentMethodSelect = $('select[name=payment_method]');
        const inputPaymentBankName = $('input[name=payment_bank_name]');
        const inputPaymentCardNumber = $('input[name=payment_card_no]');
        const inputPaymentAttachment = $('input[name=payment_attachment]');

        function checkPaymentMethod () {
            if (paymentMethodSelect.val() === 'CASH') {
                inputPaymentBankName.attr('disabled', true);
                inputPaymentCardNumber.attr('disabled', true);
                inputPaymentAttachment.attr('disabled', true);
            } else {
                inputPaymentBankName.attr('disabled', false);
                inputPaymentCardNumber.attr('disabled', false);
                inputPaymentAttachment.attr('disabled', false);
            }
        }

        checkPaymentMethod();

        paymentMethodSelect.on('select2:select', function () {
            checkPaymentMethod();
        });
    });
</script>
@endpush
