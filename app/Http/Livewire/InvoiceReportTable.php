<?php

namespace App\Http\Livewire;

use App\Invoice;
use Kdion4891\LaravelLivewireTables\Column;
use Kdion4891\LaravelLivewireTables\TableComponent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceReportTable extends TableComponent
{
    public $checkbox = false;

    public $header_view = 'reports.invoice.header';

    public $branch = 0;

    public $month = null;

    public $year = null;

    public function mount()
    {
        if ($branchID = Auth::user()->branch_id) {
            $this->branch = $branchID;
        }
    }

    public function query()
    {
        $q = Invoice::with(['payments', 'ss.student', 'branch', 'ss.study'])
                    ->withCount([
                        'payments AS paid_sum' => function ($query) {
                            $query->select(DB::raw("SUM(amount) as paid_sum"));
                        }
                    ]);

        if ($this->branch != 0)
        {
            $q->where('branch_id', $this->branch);
        }

        if ($this->month) {
            $q->whereMonth('created_at', $this->month);
        }

        if ($this->year) {
            $q->whereYear('created_at', $this->year);
        }

        return $q;
    }

    public function columns()
    {
        return [
            Column::make('Cabang', 'branch.name')->searchable()->sortable(),
            Column::make('Nomor Transaksi', 'code')->searchable()->sortable(),
            Column::make('Tgl Transaksi', 'created_at')->searchable()->sortable(),
            Column::make('Nama Siswa', 'ss.student.name')->searchable()->sortable(),
            Column::make('Studi', 'ss.study.name'),
            Column::make('Jumlah Tagihan', 'amount')->sortable()->view('reports.invoice.amount'),
            Column::make('Jumlah Dibayar', 'paid_sum')->view('reports.invoice.paid_sum'),
            Column::make('Status', 'status')->view('reports.invoice.status'),
        ];
    }
}
