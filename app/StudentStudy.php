<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentStudy extends Model
{
    const DUE_DATE_DAY = 10;

    const PAYMENT_STATUS_COMPLETE = 'COMPLETE';
    const PAYMENT_STATUS_INCOMPLETE = 'INCOMPLETE';
    const PAYMENT_STATUS_INVOICING = 'INVOICING';
    const PAYMENT_STATUS_PAID = 'PAID';
    const PAYMENT_STATUS_PARTIA_PAID = 'PARTIAL PAID';
    const PAYMENT_STATUS_UNPAID = 'UNPAID';

    protected $casts = [
        'amount_paid' => 'double',
        'total_amount' => 'double',
    ];

    protected $guarded = [];

    protected $dates = ['stop_date'];

    public function isPaid()
    {
        return $this->payment_status == static::PAYMENT_STATUS_PAID;
    }

    public function isCompletePayment()
    {
        return $this->total_amount == $this->amount_paid;
    }

    public function updatePayment()
    {
        $payment = $this->payment;

        $this->payment_status = 'PAID';
        $this->amount_paid += $payment->amount;

        if ($this->is_recurring) {
            $lastPaymentDate = $this->next_payment;
            $lastPaymentTime = strtotime($lastPaymentDate ?? date('Y-m-d H:i:s'));
            $nextPaymentTime = strtotime('+1 month', $lastPaymentTime);
            $nextPaymentDate = date('Y-m-d H:i:s', $nextPaymentTime);

            $this->recurring_count += 1;

            if ($this->isCompletePayment()) {
                $this->next_payment = null;
                $this->payment_status = 'PAID';
            } else {
                $this->next_payment = $nextPaymentDate;
                $this->payment_status = (strtotime($this->next_payment) < time()) ? 'INCOMPLETE' : 'COMPLETE';
            }
        }

        unset($this->payment);

        $this->save();

        $this->payment = $payment;
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function stop(Carbon $stopDate, $comment = null)
    {
        $this->stop_date = $stopDate;
        $this->comment = $comment;
        $this->save();
    }

    public function getIsDoneAttribute()
    {

        return $this->stop_date ? true : false;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function teacher()
    {
        return $this->hasOneThrough(
            Teacher::class,
            BranchStudy::class,
            'branch_id',
            'id',
            'branch_id',
            'branch_id'
        );
    }

    public function branchStudy()
    {
        return $this->belongsTo(BranchStudy::class, 'class_id');
    }
}
