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
<h3 align="center">LAPORAN POS REKAP BIMBEL PIKAT</h3>
<h5 align="center">Dari tanggal {{ $dateStart->isoFormat('LL') }} s/d {{ $dateTo->isoFormat('LL') }}</h5>
<table width="100%">
    <thead>
    <tr>
        <th>NO</th>
        <th>Cabang</th>
        <th>PIC</th>
        <th>Jumlah</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $sale)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sale->name }}</td>
            <td>{{ $sale->pic }}</td>
            <td style="text-align: right">{{ currency($sale->total)  }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th style="text-align: center" colspan="3">T O T A L</th>
        <th style="text-align: right">{{ currency($data->sum('total')) }}</th>
    </tr>
    </tfoot>
</table>
