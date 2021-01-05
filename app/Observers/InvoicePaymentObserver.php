<?php

namespace App\Observers;

use App\InvoicePayment;
use App\StudentStudy;
use App\Branch;
use Carbon\Carbon;
use App\Invoice;

class InvoicePaymentObserver
{
    public function creating(InvoicePayment $invoicePayment)
    {
        // TODO : Generate Invoice Number Format
        $invoicePayment->code = $this->generateInvoiceNumber($invoicePayment);
    }

    protected function generateInvoiceNumber($invoicePayment)
    {
        $invoice = $invoicePayment->invoice;
        $studentStudy = StudentStudy::find($invoice->student_study_id);
        $branch = Branch::find($studentStudy->student->branch_id);
        $date = Carbon::now();
        $invoiceCount = InvoicePayment::query()->count('id');
        $code = sprintf("KW/%s/%s/%s/%s", $branch->code, $date->month, $date->year, sprintf("%05d", $invoiceCount + 1));

        if (Invoice::where('code', $code)->count() > 0) {
            return $this->generateInvoiceNumber($invoice);
        }

        return $code;
    }
}
