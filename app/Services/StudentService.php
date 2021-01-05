<?php

namespace App\Services;

use App\Student;
use App\StudentStudy;
use App\Study;
use App\Repositories\StudentStudyRepository;
use App\Repositories\InvoiceRepository;
use Carbon\Carbon;
use Exception;

class StudentService
{
    private $student;

    private $studentStudy;

    public function __construct(Student $student)
    {
        $this->student = $student;
        $this->studentStudy = new StudentStudyRepository;
    }

    public function takeStudy($study, $startDate, $billingDate, $firstPayment, $classId)
    {
        if (!$study instanceof Study) {
            $study = Study::findOrFail($study);
        }

        $start = Carbon::parse($startDate);
        $startDay = (int) $start->copy()->format('d');
        $billingDate = Carbon::parse($billingDate);
        $nextPayment = $start->copy()->addMonth(1);

        // Jika Lebih dari tgl 10, maka ambil $billing date
        if ($startDay > StudentStudy::DUE_DATE_DAY) {
            $nextPayment = $billingDate;
        }else{
            $nextPayment->day = 1;
        }

        return $this->studentStudy->create($this->student, $study, $start, $nextPayment, $firstPayment, $classId);
    }
}
