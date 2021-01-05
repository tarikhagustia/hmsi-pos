<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Invoice;
use App\InvoicePayment;

class InvoicePaid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Invoice
     */
    public $invoice;
    /**
     * @var InvoicePayment
     */
    public $invoicePayment;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     * @param InvoicePayment $invoicePayment
     */
    public function __construct(Invoice $invoice, InvoicePayment $invoicePayment)
    {
        //
        $this->invoice = $invoice;
        $this->invoicePayment = $invoicePayment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
