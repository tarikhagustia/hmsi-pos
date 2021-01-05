<?php

namespace App\Repositories;

use App\Student;
use App\Invoice;
use App\Events\InvoiceCreated;
use App\Study;
use Carbon\Carbon;

class InvoiceRepository {
    public function createForStudentTakeStudy(Student $student)
    {
        $invoice = Invoice::create([
            'student_study_id' => $student->student_study->id,
            'date' => $student->student_study->start_date,
            'due_date' => $student->student_study->next_payment->day(10), // Jatuh Tempo tiap tgl 10
            'amount' => $student->student_study->total_amount,
            'status' => Invoice::STATUS_UNPAID,
            'branch_id' => $student->branch_id
        ]);

        event(new InvoiceCreated($invoice));

        return $invoice;
    }

    public function createInvoicePackage(Student $student, Study $study, $billingDate)
    {
        $startDate = $student->student_study->start_date;
        $billingDate = Carbon::parse($billingDate);
        foreach ($study->payment_terms as $terms)
        {
            $dueDate = $startDate->copy()->addMonth(1);
            $invoice = Invoice::create([
                'student_study_id' => $student->student_study->id,
                'date' => $billingDate,
                'due_date' => $dueDate->day(10), // Jatuh Tempo tiap tgl 10
                'amount' => $student->student_study->total_amount * $terms / 100,
                'status' => Invoice::STATUS_UNPAID,
                'branch_id' => $student->branch_id
            ]);

            $billingDate->addMonth(1);
            $startDate->addMonth(1);
        }
    }

}
