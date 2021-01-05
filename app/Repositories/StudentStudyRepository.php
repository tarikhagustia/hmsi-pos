<?php

namespace App\Repositories;

use App\Student;
use App\StudentStudy;
use App\Study;
use App\InvoicePayment;
use Illuminate\Support\Facades\DB;

class StudentStudyRepository
{
    public function create(Student $student, Study $study, $start, $nextPayment, $firstPayment = 0, $classId = null)
    {
        $studentStudy = StudentStudy::create([
            'student_id'      => $student->id,
            'study_id'        => $study->id,
            'start_date'      => $start,
            'payment_status'  => StudentStudy::PAYMENT_STATUS_UNPAID,
            'is_recurring'    => $study->isRecurring(),
            'recurring_count' => null,
            'recurring_max'   => $study->recurring_times,
            'next_payment'    => $study->payment_type == "PACKAGE" ? null : $nextPayment,
            'amount_paid'     => 0,
            'total_amount'    => $firstPayment == 0 ? $study->price : $firstPayment,
            'branch_id'       => $student->branch_id,
            'class_id'        => $classId
        ]);

        return $studentStudy;
    }

    public function getSalesReport($branchID = null, $dateStart, $dateEnd)
    {
        $query = InvoicePayment::with(['invoice.ss.student'])
                               ->whereHas('invoice', function ($q) use ($branchID) {
                                   if ($branchID) {
                                       $q->where('branch_id', $branchID);
                                   }

                               })
                               ->whereBetween('created_at', [$dateStart, $dateEnd])
                               ->latest();

        return $query;
    }

    public function getSalesReportRecap($branchID = null, $dateStart, $dateEnd)
    {
        $query = DB::table("invoice_payments as ip")
                   ->select(["b.name", "b.pic_name as pic", DB::raw("SUM(ip.amount) as total")])
                   ->join("invoices as i", "ip.invoice_id", "=", "i.id")
                   ->join("branches as b", "i.branch_id", "=", "b.id")
                   ->groupBy("b.id");

        return $query;
    }
}
