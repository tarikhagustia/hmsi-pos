<?php

namespace App\Providers;

use App\Observers\StockDemandObserver;
use App\StockDemand;
use Illuminate\Support\ServiceProvider;

class ModelObserverProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
