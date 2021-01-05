<?php

namespace App\Http\Controllers\Report;

use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Branch;

class StudentReportController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function index()
    {
        return view('reports.student');
    }

    public function mutation()
    {
        return view('reports.student_mutation');
    }

    public function mutationPost(Request $request)
    {
        $startDate = Carbon::parse($request->input('date_from'));
        $endDate = Carbon::parse($request->input('date_to'));
        $branch = Branch::findOrFail($request->input('branch_id'));
        if ($request->input('report-type') == "detail") {
            $data = $this->studentRepository->getMutationReportDetailed($request->input('branch_id'), $startDate, $endDate);
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('reports.student_mutation_detail', compact('data', 'branch'));
            return $pdf->stream('Laporan Mutasi Detail.pdf');
        }else{
            $data = $this->studentRepository->getMutationReportRecap($request->input('branch_id'), $startDate, $endDate);
            $pdf = PDF::loadView('reports.student_mutation_recap', compact('data', 'branch', 'startDate', 'endDate'));
            return $pdf->stream('Laporan Mutasi Rekap.pdf');
        }

    }
}
