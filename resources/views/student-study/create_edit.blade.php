@extends('layouts.app')

@section('content')

    <x-main-content :title="$student->name .' - '. $student->school_level .' - Kelas '. $student->school_class">
        <div class="alert alert-success">
            <p>Siswa Berhasil didaftarkan, Selanjutnya silakan pilih Kursus / Bimbel yang akan diambil</p>
        </div>
        <div class="card">
            <form action="{{ request()->isEditing ?  route('teachers.update', ['teacher' => $teacher->id]) : route('student-studies.store', ['student' => $student->id]) }}" method="POST">
                @csrf
                {{ request()->isEditing ? method_field('PUT') : '' }}
                <div class="card-header">
                    <h4>{{ request()->isEditing ? 'Sunting Studi' : 'Ambil Studi' }}</h4>
                </div>
                <div class="card-body">
                    <h6>Data Studi</h6>
                    <x-form-select
                        label="Studi"
                        name="study_id"
                        :value="$student->study ?? null"
                        :error="$errors->first('study')">
                        @foreach ($studies as $study)
                            <option value="{{ $study->id }}">{{ $study->name }}</option>
                        @endforeach
                    </x-form-select>
                    <x-form-input id="price" label="Harga" :value="$studies->first()->study->price" readonly/>
                    <x-form-input id="payment-type" label="Pembayaran" :value="trans('study.'. strtolower($studies->first()->study->payment_type))" readonly/>
                    <div class="form-group">
                        <label>Tanggal mulai (tanggal-bulan-tahun)</label>
                        <input class="form-control datepicker tanggal-mulai" type="text" name="start_date" value="{{ date('d-m-Y') }}" id="start-date" placeholder="tanggal-bulan-tahun">
                    </div>
                    <div class="form-group" id="tanggal-tagihan">
                        <label>Tanggal Tagihan (Jika Tanggal Mulai lebih dari tgl 10, maka tanggal tagihan wajib diisi)</label>
                        <input class="form-control datepicker tanggal-tagihan" type="text" name="billing_date" value="{{ now()->addMonth(1)->format('d-m-Y') }}" id="first-payment-date" placeholder="tanggal-bulan-tahun">
                    </div>
                    <x-form-input id="first_payment" name="first_payment" label="Pembayaran Pertama" :value="$studies->first()->study->price" readonly/>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="{{ route('students.show', ['student' => $student->id]) }}">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection

@push('javascript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
    $(document).ready(() => {
        const tagihalEl = $('#tanggal-tagihan')

        // Cek Tanggal Sekarang
        const d = new Date()
        const inputFirstPayment = $('#first_payment');

        new Cleave('#price', {
            numeral: true,
            numeralDecimalMark: ',', delimiter: '.'
        });

        new Cleave('#first_payment', {
            numeral: true,
            numeralDecimalMark: ',', delimiter: '.'
        });

        new Cleave('#start-date', {
            date: true,
            delimiter: '-',
            datePattern: ['d', 'm', 'Y']
        });

        const studies = {!! $studies !!}
        const studySelect = $('select[name=study_id]');

        const inputPrice = $('#price');
        const firstStudy = studies.filter(study => study.id == studySelect.val())[0];
        let isPackage = (firstStudy.study.payment_type == "PACKAGE");
        if(d.getDate() >= 10) {
            tagihalEl.show()
            firstPaymentCount()
        }else{
            tagihalEl.hide()
            if(isPackage) {
                inputFirstPayment.hide()
                inputFirstPayment.siblings().hide()
            }
            inputFirstPayment.val(inputPrice.val())
            new Cleave('#first_payment', {
                numeral: true,
                numeralDecimalMark: ',', delimiter: '.'
            });
        }

        studySelect.on('select2:select', function (e) {
            const study = studies.filter(study => study.id == e.params.data.id)[0];
            isPackage = (study.study.payment_type == "PACKAGE")
            console.log(isPackage)
            if(isPackage) {
                inputFirstPayment.hide()
                inputFirstPayment.siblings().hide()
                $('#payment-type').val('Paket')
            }else{
                inputFirstPayment.show()
                inputFirstPayment.siblings().show()
                $('#payment-type').val('Bulanan')
            }
            inputPrice.val(study.study.price);
            inputFirstPayment.val(study.study.price)
            new Cleave('#price', {
                numeral: true,
                numeralDecimalMark: ',', delimiter: '.'
            });
            new Cleave('#first_payment', {
                numeral: true,
                numeralDecimalMark: ',', delimiter: '.'
            });
        });

        $('.tanggal-mulai').on('apply.daterangepicker', function (ev, picker) {
            const d = new Date(picker.startDate.format('YYYY-MM-DD'))
            if(d.getDate() >= 10) {
                tagihalEl.show()
                firstPaymentCount()
            }else{
                tagihalEl.hide()
                inputFirstPayment.val(inputPrice.val())
                new Cleave('#first_payment', {
                    numeral: true,
                    numeralDecimalMark: ',', delimiter: '.'
                });
            }
        })

        $('.tanggal-tagihan').on('apply.daterangepicker', function (ev, picker) {
            firstPaymentCount()
        })

        function firstPaymentCount() {

            let splitMilai = $('.tanggal-mulai').val().split('-')
            let splitTagihan = $('.tanggal-tagihan').val().split('-')
            var tglMulai = new Date(`${splitMilai[2]}-${splitMilai[1]}-${splitMilai[0]}`)
            var tglTagihan = new Date(`${splitTagihan[2]}-${splitTagihan[1]}-${splitTagihan[0]}`)
            console.log(tglTagihan)
            if(tglMulai.getDate() >= 10 && (tglMulai.getMonth() < tglTagihan.getMonth())) {
                console.log('Calculate')
                // Do calculate
                const days = daysInMonth(tglMulai.getMonth(), tglMulai.getFullYear())
                const price = parseInt(inputPrice.val().split(".").join(""))
                const hasil = Math.round((days - tglMulai.getDate() + tglTagihan.getDate()) * price / 30)
                if(!isPackage) {
                    inputFirstPayment.val(hasil)
                }
                new Cleave('#first_payment', {
                    numeral: true,
                    numeralDecimalMark: ',', delimiter: '.'
                });

            }
        }

        function daysInMonth (month, year) {
            return new Date(year, month, 0).getDate();
        }

    });


</script>
@endpush
