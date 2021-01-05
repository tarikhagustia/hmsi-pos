<?php

namespace App\Http\Controllers\Report;

use App\Branch;
use App\Order;
use App\Http\Controllers\Controller;
use App\OrderItem;
use App\Repositories\SaleRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{

    private $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function index()
    {
        return view('reports.sale');
    }

    public function show($code)
    {
        $order = Order::where('code', $code)->first();

        if ($order == null) {
            abort(404);
        }

        return view('reports.sale_show', compact('order'));
    }

    public function store(Request $request)
    {
        $dateStart = Carbon::parse($request->input('date_from'));
        $dateTo = Carbon::parse($request->input('date_to'));

        $branch = Branch::findOrFail($request->input('branch_id'));

        if ($request->input('report-type') == "detail") {

            $data = Order::whereBetween('created_at', [$dateStart, $dateTo])->where('branch_id',$branch->id)->get();
            $no = 1;
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('reports.sale_detail', compact('data', 'branch', 'dateStart', 'dateTo', 'no'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->stream('Laporan Penjualan POS Detail '.$branch->name.'.pdf');

        }else{

            $data = $this->saleRepository->getSaleReportRecap($branch->id, $dateStart, $dateTo)->get();

            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('reports.sale_recap', compact('data', 'branch', 'dateStart', 'dateTo'));
            return $pdf->stream('Laporan Penjualan POS Rekap.pdf');
        }
    }
}
