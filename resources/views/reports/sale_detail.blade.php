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
<h3 align="center">LAPORAN POS DETAIL {{ $branch->name }}</h3>
<h5 align="center">Dari tanggal {{ $dateStart->isoFormat('LL') }} s/d {{ $dateTo->isoFormat('LL') }}</h5>
<table width="100%">
    <thead>
    <tr>
        <th>NO</th>
        <th>TGL</th>
        <th>KODE</th>
        <th>PRODUK</th>
        <th>QTY</th>
        <th>TOTAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $sale)
        @foreach($sale->items as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $sale->created_at->isoFormat('LL') }}</td>
                <td>{{ $sale->code }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->item_qty }}</td>
                <td>{{ currency($item->total) }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th style="text-align: center" colspan="5">T O T A L</th>
        <th style="text-align: right">{{ currency($data->sum('total_amount')) }}</th>
    </tr>
    </tfoot>
</table>
