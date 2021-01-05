@component('mail::message')
<div>
    <h1>Hallo,</h1>
    <p>Invoice baru dengan nomor {{$invoice->code}} sudah tersedia, mohon untuk melunasi pembayaran anda sebelum tanggal {{$invoice->due_date}}</p>
    <p>Terimakasih</p>
</div>
@endcomponent
