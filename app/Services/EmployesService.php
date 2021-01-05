<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EntregaCanasta;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Payroll;
use App\Models\User;
use App\Utils\PaymentInfo;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $payrolls = $paymentInfo->getPayrolls();
        $employee = $paymentInfo->getEmployee();

        $payment = null;
        foreach ($payrolls as $payroll) {
            $query = [
                'trabajador_id' => $employee->id,
                'planilla_id'   => $payroll->id,
            ];

            try {
                $payment = Payment::where($query)->firstOrFail();
                break;
            } catch (\Exception $e) {
                continue;
            }
        }

        if (is_null($payment)) {
            throw new ModelNotFoundException;
        }

        $paymentInfo->setEmpresaId($payroll->empresa_id);
        $payment->mes = $paymentInfo->getMonth();
        $payment->anio = $paymentInfo->getYear();
        $payment->type_payment = $payroll->tipoPago;
        $payment->company = $payroll->empresa;
        $payment->details = PaymentDetail::where([
            'planilla_id'   => $payroll->id,
            'trabajador_id' => $employee->id
        ])->get();

        $employee->payment = $payment;
        $employee->regimen;
        $employee->tarja = $employee->jornal
            ? $this->asistenciasService->getTarjaConDigitacion($paymentInfo)
            : $this->asistenciasService->getTarjaSinDigitacion($paymentInfo);

        return $employee;
    }

    public function existTwoPayments(PaymentInfo $paymentInfo): bool
    {
        $trabajador = $paymentInfo->getEmployee();
        $planillas = $paymentInfo->getPayrolls();

        $planillasIds = array_column($planillas->toArray(), 'id');

        $countPayments = Payment::where('trabajador_id', $trabajador->id)
            ->whereIn('planilla_id', $planillasIds)
            ->count();

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
