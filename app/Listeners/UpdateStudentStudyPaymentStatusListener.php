<?php

namespace App\Listeners;

use App\Events\InvoicePaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Invoice;
use App\StudentStudy;

class UpdateStudentStudyPaymentStatusListener
{


    /**
     * Handle the event.
     *
     * @param  InvoicePaid  $event
     * @return void
     */
    public function handle(InvoicePaid $event)
    {
        $invoice = $event->invoice;

        $totalInvoices = Invoice::where('student_study_id', $invoice->student_study_id)->count();
        $paidInvoices = Invoice::where('student_study_id', $invoice->student_study_id)->where('status', Invoice::STATUS_PAID)->count();

        // If all invoice was paid, then change status to Student Study Status
        if ($totalInvoices == $paidInvoices) {
            $invoice->studentStudy->payment_status = StudentStudy::PAYMENT_STATUS_PAID;
            $invoice->studentStudy->save();
        }
    }
}
