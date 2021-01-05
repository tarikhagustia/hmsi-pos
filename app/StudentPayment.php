<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    const PAYMENT_METHOD_CASH = 'CASH';
    const PAYMENT_METHOD_BANK_TRANSFER = 'BANK_TRANSFER';

    protected $casts = [
        'payment_number' => 'integer',
        'amount' => 'double',
    ];
    
    protected $guarded = [];

    public static function generatePaymentNumber()
    {
        $lastPayment = StudentPayment::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->latest()
            ->first();

        $lastNumber = (int) substr($lastPayment->payment_number ?? null, 6);
        $baseNumber = str_pad(date('Ym'), 10, 0, STR_PAD_RIGHT);
        $newNumber = $baseNumber + ($lastNumber + 1);

        return $newNumber;
    }

    public function studentStudy()
    {
        return $this->belongsTo(StudentStudy::class);
    }
}
