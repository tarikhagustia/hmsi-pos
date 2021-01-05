<?php

namespace App\Mail;

use App\StudentStudy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $studentStudy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(StudentStudy $studentStudy)
    {
        $this->studentStudy = $studentStudy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.payments.reminder');
    }
}
