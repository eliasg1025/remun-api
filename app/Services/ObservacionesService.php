<?php

namespace App\Services;

use App\Models\Observacion;
use App\Models\User;

class ObservacionesService
{
    public function store($incidenciaCon, $objetoIncidencia, $comentario, $usuarioId, $pagoId, $tipo_pago_id)
    {
        $obs = new Observacion();
        $obs->incidencia_con = $incidenciaCon;
        $obs->objeto_incidencia = $objetoIncidencia;
        $obs->comentario = $comentario;
        $obs->usuario_id = $usuarioId;
        $obs->pago_id = $pagoId;
        $obs->tipo_pago_id = $tipo_pago_id;
        $obs->save();

        return $obs;
    }

    public function get($usuarioId, $pagoId, $tipoPagoId, $all)
    {
        $usuario = User::findOrFail($usuarioId);
        $query = [];

        if ($pagoId !== 0 || $tipoPagoId !== 0) {
            $query['pago_id'] = $pagoId;
            $query['tipo_pago_id'] = $tipoPagoId;
        }

        if ($all) {
            if ($usuario->rol->descripcion !== 'ADMINISTRADOR') {
                $query['usuario_id'] = $usuario->id;
            }
        } else {
            $query['usuario_id'] = $usuario->id;
        }

        return Observacion::where($query)->get();
    }
}
