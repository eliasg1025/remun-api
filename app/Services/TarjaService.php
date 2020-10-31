<?php

namespace App\Services;

use App\Models\Tarja;
use Illuminate\Support\Facades\DB;

class TarjaService
{
    public function __construct()
    {
        //
    }

    public function storeMany($data)
    {
        $counter = 0;

        $mes = $data['mes'];
        $anio = $data['anio'];

        foreach ($data['data'] as $row) {
            /*
            $tarja = Tarja::where([
                'trabajador_id' => $row['RUT'],
                'mes' => $row['mes'],
                'anio' => $row['anio']
            ])->first();

            if (!$tarja) {
                $tarja = new Tarja();
            }
            */

            $asistencia = [
                'trabajador_id' => $row['RUT'],
                'mes'           => $mes,
                'anio'          => $anio,
                'dia_1' => $row['1'],
                'dia_2' => $row['2'],
                'dia_3' => $row['3'],
                'dia_4' => $row['4'],
                'dia_5' => $row['5'],
                'dia_6' => $row['6'],
                'dia_7' => $row['7'],
                'dia_8' => $row['8'],
                'dia_9' => $row['9'],
                'dia_10' => $row['10'],
                'dia_11' => $row['11'],
                'dia_12' => $row['12'],
                'dia_13' => $row['13'],
                'dia_14' => $row['14'],
                'dia_15' => $row['15'],
                'dia_16' => $row['16'],
                'dia_17' => $row['17'],
                'dia_18' => $row['18'],
                'dia_19' => $row['19'],
                'dia_20' => $row['20'],
                'dia_21' => $row['21'],
                'dia_22' => $row['22'],
                'dia_23' => $row['23'],
                'dia_24' => $row['24'],
                'dia_25' => $row['25'],
                'dia_26' => $row['26'],
                'dia_27' => $row['27'],
                'dia_28' => $row['28'],
                'dia_29' => $row['29'],
                'dia_30' => $row['30'],
                'dia_31' => $row['31'],
            ];

            $counter += DB::table('tarjas')->updateOrInsert([
                'mes'           => $asistencia['mes'],
                'anio'          => $asistencia['anio'],
                'trabajador_id' => $asistencia['trabajador_id']
            ], $asistencia);
        }
        return $counter;
    }
}
