<?php

namespace App\Services;

use App\Invoice;
use App\Events\InvoicePaid;
use App\Student;
use App\StudentStudy;
use Carbon\Carbon;
use App\Events\InvoiceCreated;
use App\InvoicePayment;

class InvoiceService
{
    public function pay(Invoice $invoice, array $data)
    {
        $invoice->save();

        $receipt = InvoicePayment::create([
            'invoice_id' => $invoice->id,
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'payment_bank_name' => $data['payment_bank_name'] ?? null,
            'payment_card_no' => $data['payment_card_no'] ?? null,
            'payment_attachment' => isset($data['payment_attachment_url']) ? $data['payment_attachment_url'] : null
        ]);
        if ($invoice->payments()->sum('amount') >= $invoice->amount) {
            $invoice->status = Invoice::STATUS_PAID;
            $invoice->save();
        }

        event(new InvoicePaid($invoice, $receipt));
        return true;
    }

    /**
     * Bill student for payment and sell invoice to student and parents
     * @param StudentStudy $studentStudy
     * @return bool
     */
    public function bill(StudentStudy $studentStudy)
    {
        // Create Invoice
        $invoice = Invoice::create([
            'student_study_id' => $studentStudy->id,
            'date' => Carbon::now(),
            'due_date' => Carbon::now(),
            'amount' => $studentStudy->total_amount,
            'status' => Invoice::STATUS_UNPAID,
            'branch_id' => $studentStudy->student->branch_id
        ]);

        event(new InvoiceCreated($invoice));
        return true;
    }

    public function uploadAttachment($file)
    {
        return $file->store('documents/payments');
    }
}
