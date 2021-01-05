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
<h3 align="center">LAPORAN MUTASI REKAP SISWA PIKAT {{ $branch->name }}</h3>
<h4 align="center">Dari Tanggal {{ $startDate->isoFormat('LL') }} s/d {{ $endDate->isoFormat('LL') }}</h4>
<table width="100%">
    <thead>
    <tr>
        <th>NO</th>
        <th>KELAS</th>
        <th>MASUK</th>
        <th>KELUAR</th>
        <th>AKTIF</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $student)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->unit }}</td>
            <td>{{ $student->new_student }}</td>
            <td>{{ $student->stop_student }}</td>
            <td>{{ $student->active_student }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

