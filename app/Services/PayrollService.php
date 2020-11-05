<?php

namespace App\Services;

use App\Models\Payroll;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    public function getByEmployee(string $trabajadorId)
    {
        $pagos = DB::table('pagos')
            ->select(
                'mes',
                'anio',
                'empresa_id',
                'tipo_pago_id'
            )
            ->where([
                'trabajador_id' => $trabajadorId
            ])->get();

        $planillas = [];
        foreach ($pagos as $pago) {
            $planilla = Payroll::with('empresa', 'tipoPago')->where([
                'empresa_id' => $pago->empresa_id,
                'tipo_pago_id' => $pago->tipo_pago_id,
                'mes' => $pago->mes,
                'anio' => $pago->anio,
            ])->first();

            if ($planilla) {
                array_push($planillas, $planilla);
            }
        }

        return $planillas;
    }
}
