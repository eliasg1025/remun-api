<?php

namespace App\Services;

use App\Models\Payroll;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    public function getByEmployee(string $trabajadorId)
    {
        $pagos = DB::table('pagos as pa')
            ->select(
                'pl.mes',
                'pl.anio',
                'pl.empresa_id',
                'pl.tipo_pago_id'
            )
            ->join('planillas as pl', 'pl.id', '=', 'pa.planilla_id')
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

    public function getPeriods()
    {
        return DB::table('planillas as pl')
            ->select(
                'pl.mes',
                'pl.anio',
                DB::raw('COUNT(*) as cantidad_planillas')
            )
            ->join('pagos as pa', 'pa.planilla_id', '=', 'pl.id')
            ->groupBy('mes')
            ->groupBy('anio')
            ->orderBy('anio', 'DESC')
            ->orderBy('mes', 'DESC')
            ->get();
    }
}
