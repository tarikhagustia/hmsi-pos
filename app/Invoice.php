<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use DateTimeInterface;
use Illuminate\Http\Request;

class Invoice extends Model
{
    use HasStatus;

    const STATUS_PAID = 'PAID';
    const STATUS_PARTIAL_PAID = 'PARTIAL PAID';
    const STATUS_UNPAID = 'UNPAID';

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'amount' => 'double'
    ];

    protected $appends = ['amount_string'];

    protected $guarded = [];

    public function pay(Request $data)
    {
        if ($data->hasFile('payment_attachment'))
        {
            $paymentAttachment = (new \App\Services\InvoiceService)->uploadAttachment($data->file('payment_attachment'));

            $data->merge([
                'payment_attachment_url' => $paymentAttachment
            ]);
        }
        $data = $data->all();
        return (new \App\Services\InvoiceService)->pay($this, $data);
    }

    public function studentStudy()
    {
        return $this->belongsTo(StudentStudy::class);
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getAmountStringAttribute()
    {
        return currency($this->amount);
    }

    // Ugly
    public function ss()
    {
        return $this->belongsTo(StudentStudy::class, 'student_study_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
