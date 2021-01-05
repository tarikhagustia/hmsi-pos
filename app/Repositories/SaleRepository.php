<?php


namespace App\Repositories;


use App\Order;
use Illuminate\Support\Facades\DB;

class SaleRepository
{
    public function getSaleReportRecap($branchID = null, $dateStart, $dateTo)
    {
        $query = DB::table("orders as a")
                   ->select([DB::raw("SUM(a.total_amount) as total"), "b.pic_name as pic", "b.name"])
                   ->join("branches as b", "a.branch_id", "=", "b.id")
                   ->whereBetween('a.created_at', [$dateStart, $dateTo])
                   ->groupBy("b.id");

        return $query;
    }
}
