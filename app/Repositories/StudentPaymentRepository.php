<?php

namespace App\Repositories;

use App\StudentPayment;

class StudentPaymentRepository {
    public function create($study, $data)
    {
        $payment = StudentPayment::create([
            'student_study_id' => $study->id,
            'payment_number' => StudentPayment::generatePaymentNumber(),
            'payment_date' => date('Y-m-d H:i:s'),
            'amount' => $data['amount_paid'],
            'payment_method' => $data['payment_method'],
            'payment_bank_name' => $data['payment_bank_name'] ?? null,
            'payment_card_no' => $data['payment_card_no'] ?? null,
        ]);

        return $payment;
    }
}
