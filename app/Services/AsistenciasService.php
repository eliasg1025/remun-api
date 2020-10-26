<?php

namespace App\Services;

use App\Models\Asistencia;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class AsistenciasService
{

    public function __construct()
    {
        //
    }

    public function storeMany($data)
    {
        $counter = 0;
        foreach ($data as $row) {
            $asistencia = [
                'fecha'         => $row['fecha'],
                'horas'         => $row['horas'],
                'trabajador_id' => $row['trabajador_id'],
            ];

            $counter += DB::table('asistencias')->insert($asistencia);
        }
        return $counter;
    }

    private function diaCortoEspaniol($dia)
    {
        switch ($dia) {
            case 1:
                return 'Lun';
            case 2:
                return 'Mar';
            case 3:
                return 'Mie';
            case 4:
                return 'Jue';
            case 5:
                return 'Vie';
            case 6:
                return 'Sab';
            case 0:
                return 'Dom';
        }
    }

    public function getTarjaConDigitacion(Employee $trabajador)
    {
        $fechaIncial = now()->firstOfMonth();
        $quincena = now()->firstOfMonth()->addDays(14);

        /*
        if ($fechaActual->greaterThan($quincena)) {
            $fechaFinal = $fechaActual->lastOfMonth();
        } else {
            $fechaFinal = $quincena;
        }*/
        $fechaFinal = $quincena;

        $periodo = CarbonPeriod::create($fechaIncial, $fechaFinal);
        $tmp = [];

        $asistencias = Asistencia::where([
                'trabajador_id' => $trabajador->id,
            ])
            ->whereDate('fecha', '>=', $fechaIncial->toDateString())
            ->whereDate('fecha', '<=', $fechaFinal->toDateString())
            ->get()->toArray();

        $dias = array_column($asistencias, 'fecha');
        $horas = array_column($asistencias, 'horas');

        foreach ($periodo as $dia) {
            $str_dia = $dia->format('Y-m-d');
            $index = array_search($str_dia, $dias);

            $fecha = $this->diaCortoEspaniol($dia->dayOfWeek) . ' ' . $dia->day;
            if ( !is_bool($index) ) {
                array_push($tmp, [
                    'fecha' => $fecha,
                    'horas' => $horas[$index]
                ]);
            } else {
                array_push($tmp, [
                    'fecha' => $fecha,
                    'horas' => 0
                ]);
            }
        }

        return $tmp;
    }

    public function getTarjaSinDigitacion(Employee $trabajador)
    {
        $fechaIncial = now()->firstOfMonth();
        $quincena = now()->firstOfMonth()->addDays(14);

        /*
        if ($fechaActual->greaterThan($quincena)) {
            $fechaFinal = $fechaActual->lastOfMonth();
        } else {
            $fechaFinal = $quincena;
        }*/
        $fechaFinal = $quincena;

        $periodo = CarbonPeriod::create($fechaIncial, $fechaFinal);
        $tmp = [];

        $asistencias = Asistencia::where([
                'trabajador_id' => $trabajador->id,
            ])
            ->whereDate('fecha', '>=', $fechaIncial->toDateString())
            ->whereDate('fecha', '<=', $fechaFinal->toDateString())
            ->get()->toArray();

        $dias = array_column($asistencias, 'fecha');
        $horas = array_column($asistencias, 'horas');

        foreach ($periodo as $dia) {
            $str_dia = $dia->format('Y-m-d');
            $index = array_search($str_dia, $dias);

            $fecha = $this->diaCortoEspaniol($dia->dayOfWeek) . ' ' . $dia->day;
            if ( !is_bool($index) ) {
                array_push($tmp, [
                    'fecha' => $fecha,
                    'horas' => 8 - $horas[$index]
                ]);
            } else {
                array_push($tmp, [
                    'fecha' => $fecha,
                    'horas' => $dia->dayOfWeek === 0 ? 0 : 8
                ]);
            }
        }

        return $tmp;
    }
}
