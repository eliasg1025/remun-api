<?php

namespace App\Services;

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
            $asistencia = [
                'trabajador_id' => $row['RUT'],
                'mes'           => $mes,
                'anio'          => $anio,
                '1' => $row['1'],
                '2' => $row['2'],
                '3' => $row['3'],
                '4' => $row['4'],
                '5' => $row['5'],
                '6' => $row['6'],
                '7' => $row['7'],
                '8' => $row['8'],
                '9' => $row['9'],
                '10' => $row['10'],
                '11' => $row['11'],
                '12' => $row['12'],
                '13' => $row['13'],
                '14' => $row['14'],
                '15' => $row['15'],
                '16' => $row['16'],
                '17' => $row['17'],
                '18' => $row['18'],
                '19' => $row['19'],
                '20' => $row['20'],
                '21' => $row['21'],
                '22' => $row['22'],
                '23' => $row['23'],
                '24' => $row['24'],
                '25' => $row['25'],
                '26' => $row['26'],
                '27' => $row['27'],
                '28' => $row['28'],
                '29' => $row['29'],
                '30' => $row['30'],
                '31' => $row['31'],
            ];

            $counter += DB::table('tarjas')->updateOrInsert(
                [
                    'mes'           => $asistencia['mes'],
                    'anio'          => $asistencia['anio'],
                    'trabajador_id' => $asistencia['trabajador_id']
                ]
            , $asistencia);
        }
        return $counter;
    }
}
