@extends('layouts.app')

@section('content')
    <form action="{{ request()->isEditing ?  route('stock-demand.update', $stockDemand) : route('stock-demand.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <x-main-content title="Inventory">
        <div class="card">
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Ubah Permintaan Barang Baru' : 'Buat Permintaan Barang Baru' }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input class="form-control{{ $errors->first('code', ' is-invalid') }}" type="text" name="code" value="{{ old('code', isset($stockDemand) ? $stockDemand->code : '[Otomatis]') }}" readonly>
                        {!! $errors->first('code', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Komentar</label>
                        <textarea class="form-control{{ $errors->first('comment', ' is-invalid') }}" cols="10" rows="20" name="comment">{{ old('comment', isset($stockDemand) ? $stockDemand->comment : '') }}</textarea>
                        {!! $errors->first('comment', '<p class="invalid-feedback">:message</p>') !!}
                    </div>

                </div>

        </div>
        <div class="card">
            <x-table-view title="Data Permintaan Barang">
                <button class="btn btn-info mb-2" id="btn-add-row" type="button">Tambah Catatan</button>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah Barang</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                        </thead>
                        <tbody id="p-row-added">
                        @if(!request()->isEditing)
                            <tr>
                                <td>
                                    <select class="form-control select2" name="item[]">
                                        @foreach($products as $p)
                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="number" name="qty[]" value="0">
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-danger btn-sm d-inline-block p-remove-row" href="#" data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @else
                            @foreach($stockDemand->items as $i)
                                <tr>
                                    <td>
                                        <select class="form-control select2" name="item[]">
                                            @foreach($products as $p)
                                                <option value="{{$p->id}}" {{ $p->id === $i->product_id ? 'selected' : null }}>{{$p->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" name="qty[]" value="{{$i->requested_qty}}">
                                    </td>
                                    <td class="text-center">
{{--                                        <a class="btn btn-danger btn-sm d-inline-block p-remove-row" href="#" data-toggle="tooltip" data-placement="top" title="Hapus">--}}
{{--                                            <i class="fas fa-trash"></i>--}}
{{--                                        </a>--}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </x-table-view>
            <div class="card-footer text-right">
                <a class="btn btn-secondary" href="{{ route('stock-demand.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </div>
    </x-main-content>
    </form>
@endsection

@push('javascript')
    <script type="text/javascript">
        $(function () {
            let btnAddRow = $('#btn-add-row');
            const btnRemove = $('.p-remove-row');
            const rowContent = `<tr>
                            <td>
                                <select class="form-control select2" name="item[]">
                                    @foreach($products as $p)
            <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
            </select>
        </td>
        <td>
            <input class="form-control" type="number" name="qty[]" value="0">
        </td>
        <td class="text-center">
            <a class="btn btn-danger btn-sm d-inline-block p-remove-row" href="#" data-toggle="tooltip" data-placement="top" title="Hapus">
                <i class="fas fa-trash"></i>
            </a>
        </td>
    </tr>`;
            const btnRowRemoveFunction = function(){
                $('.p-remove-row').click(function (e) {

                    e.preventDefault();
                    $(this).parent().parent().remove();
                });
            };
            btnRowRemoveFunction();

            btnAddRow.click(function () {
                $('#p-row-added').append(rowContent);
                $('.select2').select2();
                btnRowRemoveFunction();
            });


        })
    </script>
@endpush
