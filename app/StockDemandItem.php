<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockDemandItem extends Model
{
    protected $guarded = [];

    public function demand()
    {
        return $this->belongsTo(StockDemand::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
