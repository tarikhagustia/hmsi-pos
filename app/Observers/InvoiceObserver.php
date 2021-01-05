<?php

namespace App\Observers;

use App\Invoice;
use Illuminate\Support\Str;
use App\StudentStudy;
use App\Branch;
use Carbon\Carbon;

class InvoiceObserver
{
    public function creating(Invoice $invoice)
    {
        // TODO : Generate Invoice Number Format
        $invoice->code = $this->generateInvoiceNumber($invoice);
    }

    protected function generateInvoiceNumber($invoice)
    {
        $studentStudy = StudentStudy::find($invoice->student_study_id);
        $branch = Branch::find($studentStudy->student->branch_id);
        $date = Carbon::now();
        $invoiceCount = Invoice::query()->count('id');
        $code = sprintf("TG/%s/%s/%s/%s", $branch->code, $date->month, $date->year, sprintf("%05d", $invoiceCount + 1));

        if (Invoice::where('code', $code)->count() > 0) {
            return $this->generateInvoiceNumber($invoice);
        }

        return $code;
    }
}
