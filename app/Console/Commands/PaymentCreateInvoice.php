<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\StudentStudy;
use Carbon\Carbon;
use App\Services\InvoiceService;

class PaymentCreateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Invoice Base on study';
    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * Create a new command instance.
     *
     * @param InvoiceService $invoiceService
     */
    public function __construct(InvoiceService $invoiceService)
    {
        parent::__construct();
        $this->invoiceService = $invoiceService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get Today Payment
        $studies = StudentStudy::whereDate('next_payment', Carbon::now())->get();

        foreach ($studies as $study)
        {
            $this->invoiceService->bill($study);
        }
    }
}
