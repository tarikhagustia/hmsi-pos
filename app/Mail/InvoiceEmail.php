<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Invoice;

class InvoiceEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Invoice
     */
    public $invoice;


    /**
     * Create a new message instance.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {

        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Invoice Baru sudah tersedia #{$this->invoice->code}")
                    ->markdown('mails.payments.invoice');
    }
}
