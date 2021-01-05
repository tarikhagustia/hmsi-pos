@extends('layouts.app')

@section('content')
    <x-main-content title="Master Data">
        <div class="card">
            <form action="{{ request()->isEditing ?  route('studies-bundle.update', ['study' => $study->id]) : route('studies-bundle.store') }}" method="POST" id="form-submit">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Studi (Bundle)' : 'Tambah Studi (Bundle)' }}</h4>
                </div>
                <div class="card-body" id="form-edit-create">
                    <x-form-input
                            label="Unit"
                            name="unit"
                            :value="$study->unit ?? null"
                            :error="$errors->first('unit')"/>
                    <x-form-input
                            label="Level"
                            name="level"
                            :value="$study->level ?? null"
                            :error="$errors->first('level')"/>
                    <x-form-input
                            label="Frekuensi"
                            name="number_of_meeting"
                            type="number"
                            :value="$study->number_of_meeting ?? null"
                            :error="$errors->first('number_of_meeting')"/>
                    <x-form-input
                            label="Keterangan"
                            name="desc"
                            type="textarea"
                            :value="$study->desc ?? null"
                            :error="$errors->first('desc')"/>
                    <x-form-input
                            label="Harga"
                            name="price"
                            type="text"
                            :value="$study->price ?? null"
                            :error="$errors->first('price')"/>
                    <x-form-input
                            id="installment_duration"
                            label="Termin Pembayaran"
                            name="installment_duration"
                            :value="$study->installment_duration ?? 1"
                            :error="$errors->first('installment_duration')"/>
                    <div id="installment_percentage">
                       @if(isset($study))
                           @foreach($study->payment_terms as $key => $p)
                            <x-form-input
                                    :label="'Pembayaran Ke - ' . $key . ' (Dalam persen)'"
                                    :name="'installment_percentage['.$p.']'"
                                    :value="$p"
                                    :error="$errors->first('installment_duration')"/>
                            @endforeach
                       @else
                            <x-form-input
                                    label="Pembayaran Ke - 1 (Dalam persen)"
                                    name="installment_percentage[0]"
                                    :value="0"
                                    :error="$errors->first('installment_duration')"/>
                       @endif

                    </div>

                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary mr-1" href="{{ route('studies-bundle.index') }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection

@push('javascript')
<script>
    $(document).ready(function () {
        new Cleave('input[name=price]', {
            numeral: true,
            numeralDecimalMark: ',', delimiter: '.'
        });

        const paymentSelect = $('select[name=payment_type]');
        const recurringTimes = $('input[name=recurring_times]');

        function checkPaymentType () {
            if (paymentSelect.val() === 'ONE TIME') {
                recurringTimes.attr('disabled', true);
            } else {
                recurringTimes.attr('disabled', false);
            }
        }

        checkPaymentType();

        paymentSelect.on('select2:select', function (e) {
            const val = e.params.data.id

            checkPaymentType();
        })

        $('#installment_duration').keyup(function(){
            const val = $(this).val()
            let html = "";
            for (let i = 1; i <= val ; i++) {
                html += `
                <div class="form-group">
                <label>Pembayaran Ke - ${i} (Dalam persen)</label>
                        <input class="form-control installment_percentage" type="number" name="installment_percentage[${i}]" value="0" id="installment_duration">
                </div>
                `;
            }
            $('#installment_percentage').html(html)

        })

        $('#form-submit').on('submit', function (e) {

            let total = 0;
            $('input[name^="installment_percentage"]').each(function(e) {
                total += parseFloat($(this).val())
            });
            console.log(total)
            if(total != 100) {
                alert('Jumlah Termin harus 100%')
                return false;
            }else{
                return true;
            }
        })


    });
</script>
@endpush
