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
<h3 align="center">LAPORAN MUTASI SISWA PIKAT {{ $branch->name }}</h3>
@foreach($data as $key => $row)
    <h4 align="center">KETERANGAN MUTASI KELUAR {{ $key }}</h4>
    <table width="100%">
        <thead>
           <tr>
               <th>NO</th>
               <th>NAMA</th>
               <th>TGL</th>
               <th>LEVEL</th>
               <th>SEKOLAH</th>
               <th>GURU</th>
               <th>KETERANGAN</th>
           </tr>
        </thead>
        <tbody>
        @php
        // dd($row)
        @endphp
        @foreach($row as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->student->name }}</td>
                <td>{{ $student->stop_date->format("d/m/Y") }}</td>
                <td>{{ $student->study->name }}</td>
                <td>{{ $student->student->school_name }}</td>
                <td>{{ $student->branchStudy ? ($student->branchStudy->teacher ? $student->branchStudy->teacher->name : '-') : '-'  }}</td>
                <td>{{ $student->comment ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
