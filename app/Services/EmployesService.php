<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EntregaCanasta;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\User;
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

    public function storeMany(array $data, $nombre_tabla = 'trabajador_')
    {
        $counter = 0;
        foreach ($data as $row) {
            $trabajador = [
                'id'               => $row[$nombre_tabla . 'id'],
                'nombre'           => $row[$nombre_tabla . 'nombre'],
                'apellido_paterno' => $row[$nombre_tabla . 'apellido_paterno'],
                'apellido_materno' => $row[$nombre_tabla . 'apellido_materno'],
                'jornal'           => $row[$nombre_tabla . 'jornal'],
                'regimen_id'       => $row[$nombre_tabla . 'regimen_id'],
                'oficio'           => $row[$nombre_tabla . 'oficio'],
                'sueldo_bruto'     => $row[$nombre_tabla . 'sueldo_bruto'],
                'empresa_id'       => $row[$nombre_tabla . 'empresa_id'] ?? null,
            ];

            $counter += DB::table('trabajadores')->updateOrInsert(['id' => $trabajador['id']], $trabajador);
        }
        return $counter;
    }

    public function getPayment(PaymentInfo $paymentInfo):? Employee
    {
        // dd($paymentInfo->getPayroll());
        $payroll = $paymentInfo->getPayroll();
        $query = [
            'trabajador_id' => $paymentInfo->getEmployee()->id,
            'planilla_id'   => $payroll->id,
        ];

        /* if ($paymentInfo->getEmpresaId() !== 0) {
            $query['empresa_id'] = $paymentInfo->getEmpresaId();
        } */

        $payment = Payment::where($query)->first();

        if (!$payment) {
            $empresa_id = $payroll->empresa_id;
            $payroll = $paymentInfo->getPayroll($empresa_id === 9 ? 14 : 9);
            $payment = Payment::where([
                'trabajador_id' => $paymentInfo->getEmployee()->id,
                'planilla_id' => $payroll->id
            ])->first();
        }
        $paymentInfo->setEmpresaId($paymentInfo->getPayroll()->empresa_id);
        $payment->mes = $paymentInfo->getMonth();
        $payment->anio = $paymentInfo->getYear();
        $payment->type_payment = $paymentInfo->getPayroll()->tipoPago;
        $payment->company = $paymentInfo->getPayroll()->empresa;
        $payment->details = PaymentDetail::where([
            'planilla_id'   => $paymentInfo->getPayroll()->id,
            'trabajador_id' => $paymentInfo->getEmployee()->id
        ])->get();

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
            'planilla_id' => $paymentInfo->getPayroll()->id,
        ];

        $countPayments = Payment::where($query)->count();

        return $countPayments >= 2;
    }

    public function getUltimaEntregaCanasta(Employee $employee): Employee
    {
        if ($employee->empresa_id) {
            $employee->empresa;
        }

        /* $entregaCanasta = EntregaCanasta::with('usuario.trabajador')
            ->where('trabajador_id', $employee->id)
            ->where('valida', true)
            ->orderBy('created_at', 'DESC')
            ->first(); */

        $entregaCanasta = DB::table('entregas_canastas')
            ->select(
                'id',
                'empresa_id',
                'created_at',
                'usuario_id',
                'trabajador_id',
            )
            ->where('trabajador_id', $employee->id)
            ->where('valida', true)
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($entregaCanasta) {
            $entregaCanasta->usuario = User::with('trabajador')->where('id', $entregaCanasta->usuario_id)->first();
        }

        $employee->entrega_canasta = $entregaCanasta;

        return $employee;
    }
}
