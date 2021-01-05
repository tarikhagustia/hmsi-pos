<style>
    body {
        font-family: "sans-serif";

    }

    table {
        border-collapse: collapse;
        font-size: 12px;
    }

    table, th, td {
        border: 1px solid black;
    }

    table {
        width: 100%;
    }

    th {
        height: 10px;
    }

    th, td {
        padding: 5px;
        text-align: left;
    }
</style>
<h3 align="center">LAPORAN PENJUALAN DETAIL {{ $branch->name }}</h3>
<table width="100%">
    <thead>
    <tr>
        <th>NO</th>
        <th>TGL</th>
        <th>NO. TAGIHAN</th>
        <th>NAMA</th>
        <th>KELAS</th>
        <th>STUDI</th>
        <th>JUMLAH DIBAYAR</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $sale)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sale->created_at->isoFormat('LL') }}</td>
            <td>{{ $sale->invoice->code }}</td>
            <td>{{ $sale->invoice->ss->student->name }}</td>
            <td>{{ $sale->invoice->ss->student->school_level }}</td>
            <td>{{ $sale->invoice->ss->study->name }}</td>
            <td style="text-align: right">{{ currency($sale->amount)  }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th style="text-align: center" colspan="6">T O T A L</th>
        <th style="text-align: right">{{ currency($data->sum('amount')) }}</th>
    </tr>
    </tfoot>
</table>
