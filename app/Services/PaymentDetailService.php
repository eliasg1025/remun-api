<?php

namespace App\Services;

use App\Models\Employee;
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
        $counter = 0;
        foreach ($data as $row) {
            $entidad = [
                'id'           => $row['id'],
                'pago_id'      => $row['liquidacion_id'],
                'concepto'     => $row['concepto'],
                'monto'        => $row['monto'],
                'tipo'         => $row['tipo'],
                'tipo_pago_id' => 1
            ];

            $counter += DB::table('detalles_pagos')->updateOrInsert([
                'id' => $entidad['id'],
                'concepto' => $entidad['concepto'],
                'tipo_pago_id' => $entidad['tipo_pago_id'],
            ], $entidad);
        }
        return $counter;
    }
}
