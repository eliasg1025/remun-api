<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payment;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
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
                'jornal'           => $row[$nombre_tabla . 'jornal']
            ];

            $counter += DB::table('trabajadores')->updateOrInsert(['id' => $trabajador['id']], $trabajador);
        }
        return $counter;
    }

    public function getPayment(PaymentInfo $paymentInfo):? Employee
    {
        $payment = Payment::where([
            'trabajador_id' => $paymentInfo->getEmployee()->id,
            'mes'           => $paymentInfo->getMonth(),
            'anio'          => $paymentInfo->getYear(),
            'tipo_pago_id'  => $paymentInfo->getTypePaymentId()
        ])->firstOrFail();
        $payment->typePayment;
        $payment->details;
        $employee = $paymentInfo->getEmployee();

        $employee->payment = $payment;
        $employee->tarja = $employee->jornal
            ? $this->asistenciasService->getTarjaConDigitacion($paymentInfo)
            : $this->asistenciasService->getTarjaSinDigitacion($paymentInfo);

        return $employee;
    }
}
