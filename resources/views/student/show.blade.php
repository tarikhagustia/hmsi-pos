@extends('layouts.app')

@section('content')
    @if(session()->has('error'))
    <div class="alert alert-warning">{{ session('error') }}</div>
    @endif
    <x-main-content title="Pelajar">
        <div class="card">
            <div class="card-header">
                <h4>Informasi Pelajar</h4>
                <div class="card-header-action">
                    <a class="btn btn-primary" href="{{ route('students.edit', ['student' => $student->id]) }}">Sunting</a>
                </div>
            </div>
            <div class="card-body">
                <x-label-row label="Branch" :value="$student->branch->name"/>
                <x-label-row label="KODE" :value="$kode"/>
                <x-label-row label="Nomor Identitas (NIS, NIM, NISN)" :value="$student->student_uid"/>
                <x-label-row label="Nama" :value="$student->name"/>
                <x-label-row label="Email" :value="$student->email"/>
                <x-label-row label="Alamat" :value="$student->address"/>
                <x-label-row label="Provinsi" :value="$student->city->province->province_name"/>
                <x-label-row label="Kota" :value="$student->city->city_name_full"/>
                <x-label-row label="Telepon" :value="$student->phone_number"/>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Informasi Sekolah</h4>
                <div class="card-header-action">
                    <a class="btn btn-primary" href="{{ route('students.edit', ['student' => $student->id]) }}">Sunting</a>
                </div>
            </div>
            <div class="card-body">
                <x-label-row label="Nama" :value="$student->school_name"/>
                <x-label-row label="Alamat" :value="$student->school_address"/>
                <x-label-row label="Tingkat" :value="$student->school_level"/>
                <x-label-row label="Kelas" :value="$student->school_class"/>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Informasi Wali</h4>
                <div class="card-header-action">
                    <a class="btn btn-primary" href="{{ route('students.edit', ['student' => $student->id]) }}">Sunting</a>
                </div>
            </div>
            <div class="card-body">
                <x-label-row label="Nama" :value="$student->guardian_name"/>
                <x-label-row label="Status" :value="$student->guardian_type"/>
                <x-label-row label="Telepon" :value="$student->guardian_phone_number"/>
                <x-label-row label="Alamat" :value="$student->guardian_address"/>
                <x-label-row label="Pekerjaan" :value="$student->guardian_job"/>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Studi</h4>
                <div class="card-header-action">
                    <a class="btn btn-primary" href="{{ route('student-studies.create', ['student' => $student->id]) }}">Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th class="text-center" width="200">Tanggal Mulai</th>
                            <th class="text-center" width="200">Tanggal Selesai</th>
                            <th class="text-center" width="200">Status Pembayaran</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->studies as $study)
                            <tr>
                                <td>{{ $study->study->name }}</td>
                                @if($study->branchStudy)
                                    <td>{{ $study->branchStudy->name}}<a style="display: block" href="#" class="modal-action-change-class" data-id="{{ $study->id }}">Set kelas</a> </td>
                                @else
                                    <td><a href="#" class="modal-action-change-class" data-id="{{ $study->id }}">Set kelas</a> </td>
                                @endif

                                <td class="text-center">{{ $study->start_date }}</td>
                                <td class="text-center">{{ $study->stop_date ?? '-' }}</td>
                                <td class="text-center">{{ $study->payment_status }}</td>
                                <td class="text-center" width="10%">
                                    @if(!$study->is_done)
                                    <a class="btn btn-danger btn-sm modal-action-stop" data-id="{{$study->id}}" data-toggle="tooltip" title="Hentikan Pembayaran">
                                        <i class="fas fa-stop"></i>
                                    </a>
                                    @endif

                                        <a class="btn btn-info btn-sm" href="{{ route('student-studies.show', ['student' => $student->id, 'student_study' => $study->id]) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <form class="modal-part" id="modal-login-part">
                <p>Isi tanggal dibawah dengan tanggal berhenti / keluar siswa</p>
                <div class="form-group">
                    <label>Tanggal Berhenti</label>
                    <input type="date" class="form-control" placeholder="Tanggal Berhenti" name="date_stop" value="{{ now()->format('d/M/Y') }}">
                </div>
                <div class="form-group">
                    <label>Keterangan (Opsional)</label>
                    <textarea class="form-control" placeholder="Keterangan" name="comment"></textarea>
                </div>
            </form>

            <form class="modal-part" id="modal-change-class">
                <p>Siswa ini belum memilih kelas, silakan tentukan kelas</p>
                <div class="form-group">
                    <label>Pilih kelas</label>
                    <select name="class_id" class="form-control select2-init" style="width: 100%; z-index: 100000">
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </x-main-content>
@endsection
@push('javascript')
    <script type="text/javascript">
        $(function(){
            $(".modal-action-stop").on('click', function(){
                let study_id = $(this).data('id');
                $(this).fireModal({
                    title: 'Form Mutasi Siswa',
                    body: $("#modal-login-part"),
                    footerClass: 'bg-whitesmoke',
                    autoFocus: false,
                    onFormSubmit: function(modal, e, form) {
                        // Form Data
                        let form_data = $(e.target).serialize();
                        $.ajax({
                            url: `/admin/student-study/${study_id}/stop`,
                            method: "post",
                            data: form_data,
                            success: function(){
                                modal.find('.modal-footer').html('<div class="mr-auto"><a href="{{ route('student-studies.create', $student) }}">Lanjut Daftar Studi Baru</a></div>');
                            },
                            error: function(){

                            },
                            complete: function () {
                                form.stopProgress()
                            }
                        })
                        e.preventDefault();
                    },
                    shown: function(modal, form) {
                        console.log(form)
                    },
                    buttons: [
                        {
                            text: 'Submit',
                            submit: true,
                            class: 'btn btn-primary btn-shadow',
                            handler: function(modal) {
                            }
                        }
                    ]
                });

                $(this).unbind();
            });

            $(".modal-action-change-class").on('click', function(){

                let study_id = $(this).data('id');
                $(this).fireModal({
                    title: 'Form isi kelas',
                    body: $("#modal-change-class"),
                    footerClass: 'bg-whitesmoke',
                    autoFocus: false,
                    onFormSubmit: function(modal, e, form) {
                        // Form Data
                        let form_data = $(e.target).serialize();
                        $.ajax({
                            url: `/admin/student-study/${study_id}/change-class`,
                            method: "post",
                            data: form_data,
                            success: function(){
                                modal.find('.modal-footer').html('<div class="alert alert-success"> Success edit class, this page will reloaded</div>');
                                setTimeout(function () {
                                    location.reload()
                                }, 3000)
                            },
                            error: function(){

                            },
                            complete: function () {
                                form.stopProgress()
                            }
                        })
                        e.preventDefault();
                    },
                    shown: function(modal, form) {
                        console.log(form)
                    },
                    buttons: [
                        {
                            text: 'Submit',
                            submit: true,
                            class: 'btn btn-primary btn-shadow',
                            handler: function(modal) {
                            }
                        }
                    ]
                });

                $(this).unbind();
            });
        })

    </script>
@endpush
