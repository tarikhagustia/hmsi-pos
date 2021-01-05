<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <title>Print</title>
</head>
<body>
    <div class="ticket">
        {{-- <div class="centered">
            <img src="{{ asset('images/logo-primary.png') }}" alt="logo">
        </div> --}}
        <p class="centered">
            <b>{{ $receipt->company }}</b>
            <br>{{ $receipt->address }}
        </p>
        <p>Tgl. {{ $receipt->time }}</p>
        <p>Kasir : {{ $receipt->cashier }}</p>
        <table>
            <thead>
                <tr>
                    <th class="quantity">Jumlah</th>
                    <th class="description">Barang</th>
                    <th class="price">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receipt->items as $item)
                    <tr>
                        <td class="quantity">{{ $item->item_qty }}</td>
                        <td class="description">{{ $item->item_name }}</td>
                        <td class="price">{{ number_format($item->item_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="centered">TERIMA KASIH</p>
    </div>
</body>
</html>
