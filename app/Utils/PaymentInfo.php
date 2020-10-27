<?php

namespace App\Utils;

use App\Models\Employee;
use Carbon\Carbon;

class PaymentInfo
{
    private Employee $employee;
    private Carbon $period;
    private int $typePaymentId;

    public function __construct($employee, $period, $typePaymentId)
    {
        $this->employee = $employee;
        $this->period = $period;
        $this->typePaymentId = $typePaymentId;
    }

    public function getEmployee()
    {
        return $this->employee;
    }

    public function getPeriod()
    {
        return $this->period;
    }

    public function getMonth()
    {
        return $this->period->month;
    }

    public function getYear()
    {
        return $this->period->year;
    }

    public function getTypePaymentId()
    {
        return $this->typePaymentId;
    }
}
