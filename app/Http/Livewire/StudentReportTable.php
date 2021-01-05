<?php

namespace App\Http\Livewire;

use App\Student;
use Kdion4891\LaravelLivewireTables\Column;
use Kdion4891\LaravelLivewireTables\TableComponent;

class StudentReportTable extends TableComponent
{
    public $checkbox    = false;

    public $header_view = 'reports.student_table_header';

    public $branch      = 0;

    public $month = null;

    public $year = null;

    public function query()
    {
        $query = Student::with(['branch']);

        $query->when($this->branch > 0, function ($query){
            $query->where('branch_id', $this->branch);
        });

        $query->when($this->month, function ($query){
            $query->whereMonth('created_at', $this->month);
        });

        $query->when($this->year, function ($query){
            $query->whereYear('created_at', $this->year);
        });

        return $query;
    }

    public function columns()
    {
        return [
            Column::make('Cabang', 'branch.name')->searchable()->sortable(),
            Column::make('Tanggal Daftar', 'created_at')->searchable()->sortable(),
            Column::make('NIK', 'student_uid')->searchable()->sortable(),
            Column::make('Nama', 'name')->searchable()->sortable(),
            Column::make('Nama Sekolah', 'school_name')->searchable()->sortable(),
            Column::make('Alamat', 'address')->searchable()->sortable(),
            Column::make('No HP', 'phone_number')->searchable()->sortable(),
        ];
    }
}
