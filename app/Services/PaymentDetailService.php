<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaymentDetailService
{
    /* public EmployeeRepositoryInterface $repository; */

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
            $entidad = [
                'planilla_id'   => $planilla->id,
                'trabajador_id' => $row['trabajador_id'],
                'concepto'      => $row['concepto'],
                'monto'         => $row['monto'],
                'tipo'          => $row['tipo']
            ];

            try {
                $counter += DB::table('detalles_pagos')->updateOrInsert([
                    'planilla_id'   => $planilla->id,
                    'trabajador_id' => $entidad['trabajador_id'],
                    'concepto'      => $entidad['concepto'],
                ], $entidad);
            } catch (\Exception $e) {
                $counter;
            }
        }
        return $counter;
    }
}
