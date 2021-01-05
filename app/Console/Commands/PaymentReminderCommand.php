<?php

namespace App\Console\Commands;

use App\Mail\PaymentReminder;
use App\StudentStudy;
use Illuminate\Console\Command;
use Mail;

class PaymentReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $studentStudies = StudentStudy::whereRaw("DATEDIFF(next_payment, NOW()) <= ". env('PAYMENT_REMINDER', 7))
            ->whereRaw("DATEDIFF(next_payment, NOW()) >= 0")
            ->get();

        foreach ($studentStudies as $item) {
            Mail::to($item->student->email)->send(new PaymentReminder($item));
        }
    }
}
