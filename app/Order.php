<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PAID = 'PAID';
    const STATUS_UNPAID = 'UNPAID';

    protected $guarded = [];

    public static function generateCode()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = 'TRX'.$year.$month;
        $number = 1;

        $lastOrder = Order::whereYear('created_at', $year)->whereMonth('created_at', $month)->latest()->first();

        if ($lastOrder != null) {
            $number = ((int) substr($lastOrder->code, strlen($prefix))) + 1;
        }

        $number = str_pad($number, 6, 0, STR_PAD_LEFT); 

        $code = $prefix.$number;

        return $code;
    }

    public function hasCustomer()
    {
        return $this->customer_id != null && $this->customer_type != null;
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }

    public function customer()
    {
        $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
