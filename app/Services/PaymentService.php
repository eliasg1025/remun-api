<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /* public PaymentRepositoryInterface $repository; */
    private PayrollService $payrollService;

    public function __construct(/* $repository */)
    {
        /* $this->repository = $repository; */
        $this->payrollService = new PayrollService();
    }

    public function storeMany(array $data)
    {
        $planilla = $this->payrollService->findOrCreate($data['empresaId'], $data['tipoPago'] === 'ANTICIPO' ? 2 : 1, $data['mes'], $data['anio']);

        $counter = 0;
        foreach ($data['data'] as $row) {
            $pago = [
                'planilla_id'   => $planilla->id,
                'trabajador_id' => $row['trabajador_id'],
                'monto'         => $row['monto'],
                'banco'         => $row['banco'],
                'numero_cuenta' => $row['numero_cuenta'],
                'zona_id'       => $row['zona_id'],
                'fecha_ingreso' => $row['fecha_inicio']
            ];

            $counter += DB::table('pagos')->updateOrInsert([
                'planilla_id'   => $planilla->id,
                'trabajador_id' => $row['trabajador_id']
            ], $pago);
        }
        return $counter;
    }
}
