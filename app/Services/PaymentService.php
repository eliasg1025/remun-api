<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /* public PaymentRepositoryInterface $repository; */

    public function __construct(/* $repository */)
    {
        /* $this->repository = $repository; */
    }

    public function storeMany(array $data)
    {
        $planilla = Payroll::where([
            'empresa_id' => $data['empresaId'],
            'tipo_pago_id' => $data['tipoPago'] === 'ANTICIPO' ? 2 : 1,
            'mes' => $data['mes'],
            'anio' => $data['anio']
        ])->first();

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
