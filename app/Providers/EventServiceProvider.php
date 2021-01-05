<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\InvoiceCreated;
use App\Listeners\SendInvoiceEmail;
use App\Events\InvoicePaid;
use App\Listeners\UpdateStudentStudyPaymentStatusListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        InvoiceCreated::class => [
            SendInvoiceEmail::class
        ],

        InvoicePaid::class => [
            UpdateStudentStudyPaymentStatusListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
