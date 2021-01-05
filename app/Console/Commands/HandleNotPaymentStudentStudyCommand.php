<?php

namespace App\Console\Commands;

use App\StudentStudy;
use Illuminate\Console\Command;

class HandleNotPaymentStudentStudyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student-study:handle-not-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle not payment student study and make it status incomplete';

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
        $studentStudies = StudentStudy::where('payment_status', StudentStudy::PAYMENT_STATUS_COMPLETE)
            ->whereRaw("DATEDIFF(next_payment, NOW()) < 0")
            ->get();

        foreach ($studentStudies as $item) {
            $item->update(['payment_status' => StudentStudy::PAYMENT_STATUS_INCOMPLETE]);
        }
    }
}
