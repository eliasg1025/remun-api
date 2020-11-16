<?php

namespace App\Services;

use App\Models\Employee;
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
        $counter = 0;
        foreach ($data as $row) {
            $pago = [
                'id'            => $row['id'],
                'mes'           => $row['mes'],
                'anio'          => $row['anio'],
                'empresa_id'    => $row['empresa_id'],
                'monto'         => $row['monto'],
                'banco'         => $row['banco'],
                'numero_cuenta' => $row['numero_cuenta'],
                'trabajador_id' => $row['trabajador_id'],
                'zona_id'       => $row['zona_id'],
                'tipo_pago_id'  => $row['tipo_pago_id'],
                'fecha_ingreso' => $row['fecha_inicio']
            ];

            $counter += DB::table('pagos')->updateOrInsert([
                'id' => $pago['id'],
                'tipo_pago_id' => $pago['tipo_pago_id'],
            ], $pago);
        }
        return $counter;
    }
}
