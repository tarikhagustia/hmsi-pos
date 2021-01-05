<?php

namespace App\Http\Controllers\Report;

use App\Order;
use App\Http\Controllers\Controller;

class InvoiceReportController extends Controller
{
    public function index()
    {
        return view('reports.invoice');
    }
}
