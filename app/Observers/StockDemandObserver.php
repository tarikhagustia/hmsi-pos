<?php

namespace App\Observers;

use App\StockDemand;

class StockDemandObserver
{
    public function creating(StockDemand $stockDemand)
    {
        // generate code
        $stockDemand->code = $this->generate($stockDemand);
    }

    protected function generate(StockDemand $stockDemand)
    {
        return sprintf("SD%s",time());
    }
}
