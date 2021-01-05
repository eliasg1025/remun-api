<?php

namespace App\Utils;

use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;

class PaymentInfo
{
    private Employee $employee;
    private Carbon $period;
    private int $typePaymentId;
    private int $empresaId;

    public function __construct($employee, $period, $typePaymentId, $empresaId)
    {
        $this->employee = $employee;
        $this->period = $period;
        $this->typePaymentId = $typePaymentId;
        $this->empresaId = $empresaId;
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

    public function getEmpresaId()
    {
        return $this->empresaId;
    }

    public function setEmpresaId(int $empresaId)
    {
        $this->empresaId = $empresaId;
    }

    public function getPayroll():? Payroll
    {
        $payroll = Payroll::where([
            'mes' => $this->getMonth(),
            'anio' => $this->getYear(),
            'tipo_pago_id' => $this->getTypePaymentId(),
            'empresa_id' => $this->getEmpresaId()
        ])->firstOrFail();

        return $payroll;
    }

    public function getPayrolls()
    {
        $payrolls = Payroll::where([
            'mes' => $this->getMonth(),
            'anio' => $this->getYear(),
            'tipo_pago_id' => $this->getTypePaymentId()
        ])
        ->when($this->getEmpresaId() !== 0, function($query) {
            $query->where('empresa_id', $this->getEmpresaId());
        })
        ->get();

        return $payrolls;
    }
}
