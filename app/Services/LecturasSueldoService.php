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

    public function get($desde, $hasta)
    {
        return DB::select("
            select
                l.id,
                date(l.fecha_hora) as fecha,
                time(l.fecha_hora) as hora,
                u.username,
                concat(tu.nombre, ' ', tu.apellido_paterno, ' ', tu.apellido_materno) as usuario,
                concat(p.anio, '/', p.mes, ' ', tp.descripcion) as pago,
                p.trabajador_id as rut,
                concat(t.nombre, ' ', t.apellido_paterno, ' ', t.apellido_materno) as trabajador,
                e.nombre_corto as empresa, p.zona_id
            from lecturas_sueldo as l
            inner join usuarios u on l.usuario_id = u.id
            inner join pagos p on l.pago_id = p.id and l.tipo_pago_id = p.tipo_pago_id
            inner join trabajadores t on p.trabajador_id = t.id
            inner join trabajadores tu on u.trabajador_id = tu.id
            inner join empresas e on p.empresa_id = e.id
            inner join tipos_pagos tp on p.tipo_pago_id = tp.id
            and date(l.fecha_hora) between $desde and $hasta
            order by l.fecha_hora desc;
        ");
    }

    public function getCantidadPorDia()
    {
        return DB::select("
            select count(*) as cantidad, date(lecturas_sueldo.fecha_hora) as fecha_lectura from lecturas_sueldo
            group by date(lecturas_sueldo.fecha_hora)
            order by fecha_lectura desc;
        ");
    }
}
