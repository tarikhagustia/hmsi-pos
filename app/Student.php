<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use DateTimeInterface;

class Student extends Model
{
    use HasBranch, HasStatus;

    protected $guarded = [];

    public function takeStudy($study, $startDate, $billingDate, $firstPayment = 0, $classId = null)
    {
        $studyModel = Study::findOrFail($study);

        $this->student_study = (new \App\Services\StudentService($this))->takeStudy($study, $startDate, $billingDate, $firstPayment, $classId);
        if ($studyModel->payment_type == Study::PAYMENT_TYPE_PACKAGE) {
            // Create Multiple Invoice
            (new \App\Repositories\InvoiceRepository)->createInvoicePackage($this, $studyModel, $billingDate);
        } else {
            $this->student_study->invoice = (new \App\Repositories\InvoiceRepository)->createForStudentTakeStudy($this);
        }


        return $this;
    }

    public function payStudy($data)
    {
        $this->student_study->payment = (new \App\Repositories\StudentPaymentRepository)->create($this->student_study, $data);

        $this->student_study->updatePayment();

        return $this;
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id', 'city_id');
    }

    public function studies()
    {
        return $this->hasMany(StudentStudy::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
