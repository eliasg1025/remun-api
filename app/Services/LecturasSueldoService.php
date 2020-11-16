<?php

namespace App\Services;

use App\Utils\PaymentInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturasSueldoService
{
    public function store(Carbon $periodo, $tipoPagoId, $usuarioId, $pagoId)
    {
        DB::table('lecturas_sueldo')->insert([
            'fecha_hora'    => now()->toDateTimeString(),
            'usuario_id'    => $usuarioId,
            'tipo_pago_id'  => $tipoPagoId,
            'pago_id'       => $pagoId,
        ]);
    }
}
