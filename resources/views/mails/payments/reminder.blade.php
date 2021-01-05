@component('mail::message')
<div>
    <h1>Payment Reminder</h1>
    <p>Ini merupakan notifikasi otomatis pembayaran studi anda. Kami menginformasikan bahwa anda harus melakukan pembayaran, pada tanggal <b>{{ date('d-m-Y', strtotime($studentStudy->next_payment)) }}</b> untuk studi <b>{{ $studentStudy->study->name }}</b>.</p>
    <p>Terima kasih</p>
</div>
@endcomponent
