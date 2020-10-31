<?php

namespace App\Services;

use App\Utils\PaymentInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LecturasSueldoService
{
    public function store(Carbon $periodo, $tipoPagoId, $usuarioId)
    {
        $pago = DB::table('pagos')->where([
            'mes' => $periodo->month,
            'anio' => $periodo->year,
            'tipo_pago_id' => $tipoPagoId
        ])->first();

        DB::table('lecturas_sueldo')->insert([
            'fecha_hora'    => now()->toDateTimeString(),
            'usuario_id'    => $usuarioId,
            'tipo_pago_id'  => $tipoPagoId,
            'pago_id'       => $pago->id
        ]);
    }
}
