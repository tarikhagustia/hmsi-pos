<?php

namespace App;

use App\Constants\StatusConstant;
use App\Events\StockDemandSent;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;

class StockDemand extends Model
{
    use HasStatus;

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function items()
    {
        return $this->hasMany(StockDemandItem::class);
    }

    public function send()
    {
        $this->status = StatusConstant::SENT;
        $this->save();
        event(new StockDemandSent($this));
    }
}
