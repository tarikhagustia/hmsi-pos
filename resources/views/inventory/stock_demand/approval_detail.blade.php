@extends('layouts.app')

@section('content')
    <form action="{{ request()->isEditing ?  route('stock-demand.update', $stockDemand) : route('stock-demand.approval_post', $stockDemand) }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                    <p>Setelah anda menyetujui permintaan barang ini, anda tidak bisa melakukan koreksi lagi. Harap cross check data dibawah ini sebelum anda submit</p>
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
                                    <input type="hidden" name="item[]" value="{{$i->id}}">
                                    <input type="hidden" name="product[]" value="{{$i->product->id}}">
                                </td>
                                <td>
                                    <input class="form-control" type="number" value="{{$i->requested_qty}}" readonly>
                                </td>
                                <td>
                                    <input class="form-control" type="number" name="qty[]" value="{{$i->requested_qty}}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-table-view>
            <div class="card-footer text-right">
                <a class="btn btn-secondary" href="{{ route('stock-demand.approval') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Setujui</button>
            </div>
        </div>
    </x-main-content>
    </form>
@endsection
