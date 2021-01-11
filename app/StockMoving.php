<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockMoving extends Model
{
    protected $guarded = [];

    public function movable()
    {
        return $this->morphTo();
    }
}
