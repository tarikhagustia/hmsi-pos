<?php

namespace App\Http\Controllers\Report;

use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\StudentStudyRepository;
use Carbon\Carbon;
use App\Branch;
use Barryvdh\DomPDF\Facade as PDF;

class StudySalesReportController extends Controller
{
    /**
     * @var StudentStudyRepository
     */
    private $studentStudyRepository;

    public function __construct(StudentStudyRepository $studentStudyRepository)
    {
        $this->studentStudyRepository = $studentStudyRepository;
    }

    public function index()
    {
        return view('reports.study_sales');
    }

    public function store(Request $request)
    {
        $dateStart = Carbon::parse($request->input('date_from'));
        $dateTo = Carbon::parse($request->input('date_to'));

        $branch = Branch::findOrFail($request->input('branch_id'));
        if ($request->input('report-type') == "detail") {
            $data = $this->studentStudyRepository->getSalesReport($branch->id, $dateStart, $dateTo)->get();
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('reports.study_sales_detail', compact('data', 'branch'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->stream('Laporan Penjualan Detail '.$branch->name.'.pdf');
        }else{
            $data = $this->studentStudyRepository->getSalesReportRecap($branch->id, $dateStart, $dateTo)->get();
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('reports.study_sales_recap', compact('data', 'branch', 'dateStart', 'dateTo'));
            return $pdf->stream('Laporan Penjualan Rekap.pdf');
        }
    }
}
