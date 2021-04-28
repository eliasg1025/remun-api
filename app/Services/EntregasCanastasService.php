<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EntregaCanasta;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EntregasCanastasService
{
    public EntregasService $entregasService;

    public function __construct()
    {
        $this->entregasService = new EntregasService();
    }

    public function store(User $user, Employee $employee)
    {
        try {
            $currentEntrega = $this->entregasService->getCurrentEntrega();

            $entregaCanasta = new EntregaCanasta();
            $entregaCanasta->trabajador_id = $employee->id;
            $entregaCanasta->usuario_id = $user->id;
            $entregaCanasta->empresa_id = $employee->empresa_id;
            $entregaCanasta->entrega_id = $currentEntrega->id;
            $entregaCanasta->save();

            return [
                'message' => 'Guardado correctamente',
                'data' => $entregaCanasta
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Error inesperado, inténtelo más tarde',
                'data' => [
                    'error' => $e
                ],
                'error' => true
            ];
        }
    }

    public function getReporte()
    {
        // Obtener la cantidad de canastas por dia

        $sql = "
            SELECT
                ec.id,
                tmp.trabajador_id as rut,
                date(created_at) as fecha,
                time(created_at) as hora,
                CONCAT(t.apellido_paterno, ' ', t.apellido_materno, ' ', t.nombre) as trabajador,
                CONCAT(t2.apellido_paterno, ' ', t2.apellido_materno, ' ', t2.nombre) as usuario
            from (
                SELECT ec.trabajador_id as trabajador_id, min(ec.id) as id FROM remun_api.entregas_canastas ec
                inner join entregas e on e.id = ec.entrega_id
                where e.activo = true
                group by ec.trabajador_id
            ) as tmp
            inner join entregas_canastas ec on ec.id = tmp.id
            inner join trabajadores t on t.id = tmp.trabajador_id
            inner join usuarios u on u.id = ec.usuario_id
            inner join trabajadores t2 on t2.id = u.trabajador_id
            ORDER by ec.id asc
        ";

        $rows = DB::select("
            select usuario, fecha, count(*) as cantidad from ($sql) as tmp
            group by fecha, usuario
            order by fecha, usuario;
        ");

        $fechas = array_values(array_unique(array_column(json_decode(json_encode($rows), true), 'fecha')));
        $usuarios = array_values(array_unique(array_column(json_decode(json_encode($rows), true), 'usuario')));

        // Cabeceras de Columnas
        $columnas = ['Usuario', ...$fechas];

        // Filas
        $filas = array_map(function($usuario) use ($rows, $fechas) {

            $tmp = array_map(function($fecha) use ($rows, $usuario) {
                $tmp = collect(array_values(array_filter($rows, fn($row) => $row->usuario === $usuario)));

                $cantidad = $tmp->where('fecha', $fecha)->first();

                return $cantidad ? $cantidad : [
                    'fecha'     => $fecha,
                    'cantidad'  => 0,
                ];
            }, $fechas);

            return [
                $usuario,
                ...array_column($tmp, 'cantidad'),
            ];
        }, $usuarios);

        return [
            'columnas' => $columnas,
            'filas' => $filas
        ];
    }
}
