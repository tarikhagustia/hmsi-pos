@extends('layouts.app')

@section('content')
    <x-main-content title="Inventory">
        <div class="card">
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Ubah Permintaan Barang Baru' : 'Permintaan Barang #'.$stockDemand->code}}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input class="form-control{{ $errors->first('code', ' is-invalid') }}" type="text" name="code" value="{{ old('code', isset($stockDemand) ? $stockDemand->code : '[Otomatis]') }}" readonly>
                        {!! $errors->first('code', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Komentar</label>
                        <textarea class="form-control{{ $errors->first('comment', ' is-invalid') }}" cols="10" rows="20" name="comment" readonly>{{ old('comment', isset($stockDemand) ? $stockDemand->comment : '') }}</textarea>
                        {!! $errors->first('comment', '<p class="invalid-feedback">:message</p>') !!}
                    </div>

                </div>

        </div>
        <div class="card">

            <x-table-view title="Data Permintaan Barang">
                <div class="alert alert-warning">
                    <h6>Perhatian!</h6>
                    <p>Dengan melakukan Submit, anda berarti telah menerima barang sesuai dengan deskripsi dibawah, proses tidak dapat dibatalkan</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah Permintaan</th>
                            <th>Jumlah Tersedia</th>
                        </tr>
                        </thead>
                        <tbody id="p-row-added">
                        @foreach($stockDemand->items as $i)
                            <tr>
                                <td>
                                   {{ $i->product->name }}
                                    <p class="font-weight-bold">#{{ $i->product->sku }}</p>
                                    <input type="hidden" name="item[]" value="{{$i->id}}">
                                    <input type="hidden" name="product[]" value="{{$i->product->id}}">
                                </td>
                                <td>
                                    <input class="form-control" type="number" value="{{$i->requested_qty}}" readonly>
                                </td>
                                <td>
                                        <input class="form-control" type="number" name="qty[]" value="{{$i->approved_qty}}" readonly>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-table-view>
            <div class="card-footer text-right">

                <form action="{{route('stock-demand.received', $stockDemand)}}" method="post">
                    <a class="btn btn-secondary" href="{{ route('stock-demand.index') }}">Batal</a>
                    @csrf
                    <button class="btn btn-primary" type="submit">Terima</button>
                </form>

            </div>
        </div>
    </x-main-content>
@endsection
