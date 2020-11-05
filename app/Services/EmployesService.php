<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payment;
use App\Utils\PaymentInfo;
use Illuminate\Support\Facades\DB;

class EmployesService
{
    /* public EmployeeRepositoryInterface $repository; */
    private AsistenciasService $asistenciasService;

    public function __construct(/* $repository */)
    {
        /* $this->repository = $repository; */
        $this->asistenciasService = new AsistenciasService();
    }

    public function storeMany(array $data)
    {
        $counter = 0;
        foreach ($data as $row) {
            $nombre_tabla = 'trabajador_';
            $trabajador = [
                'id'               => $row[$nombre_tabla . 'id'],
                'nombre'           => $row[$nombre_tabla . 'nombre'],
                'apellido_paterno' => $row[$nombre_tabla . 'apellido_paterno'],
                'apellido_materno' => $row[$nombre_tabla . 'apellido_materno'],
                'jornal'           => $row[$nombre_tabla . 'jornal'],
                'regimen_id'       => $row[$nombre_tabla . 'regimen_id'],
                'oficio'           => $row[$nombre_tabla . 'oficio'],
                'sueldo_bruto'     => $row[$nombre_tabla . 'sueldo_bruto']
            ];

            $counter += DB::table('trabajadores')->updateOrInsert(['id' => $trabajador['id']], $trabajador);
        }
        return $counter;
    }

    public function getPayment(PaymentInfo $paymentInfo):? Employee
    {
        $query = [
            'trabajador_id' => $paymentInfo->getEmployee()->id,
            'mes'           => $paymentInfo->getMonth(),
            'anio'          => $paymentInfo->getYear(),
            'tipo_pago_id'  => $paymentInfo->getTypePaymentId()
        ];

        if ($paymentInfo->getEmpresaId() !== 0) {
            $query['empresa_id'] = $paymentInfo->getEmpresaId();
        }

        $payment = Payment::where($query)->firstOrFail();
        $payment->typePayment;
        $payment->details;
        $payment->company;
        $employee = $paymentInfo->getEmployee();

        $employee->payment = $payment;
        $employee->regimen;
        $employee->tarja = $employee->jornal
            ? $this->asistenciasService->getTarjaConDigitacion($paymentInfo)
            : $this->asistenciasService->getTarjaSinDigitacion($paymentInfo);

        return $employee;
    }

    public function existTwoPayments(PaymentInfo $paymentInfo): bool
    {
        $query = [
            'trabajador_id' => $paymentInfo->getEmployee()->id,
            'mes'           => $paymentInfo->getMonth(),
            'anio'          => $paymentInfo->getYear(),
            'tipo_pago_id'  => $paymentInfo->getTypePaymentId()
        ];

        $countPayments = Payment::where($query)->count();

        return $countPayments >= 2;
    }
}
