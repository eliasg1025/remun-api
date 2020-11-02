<?php

namespace App\Services;

use App\Models\Asistencia;
use App\Models\Employee;
use App\Models\Tarja;
use App\Utils\PaymentInfo;
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
                'motivo'        => $row['motivo'],
                'con_goce'      => $row['con_goce']
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

    public function getTarjaConDigitacion(PaymentInfo $paymentInfo)
    {
        $trabajador  = $paymentInfo->getEmployee();
        $fechaIncial = clone $paymentInfo->getPeriod()->firstOfMonth();
        $fechaFinal = $paymentInfo->getTypePaymentId() === 2
            ? clone $paymentInfo->getPeriod()->addDays(14)
            : clone $paymentInfo->getPeriod()->lastOfMonth();

        $periodo = CarbonPeriod::create($fechaIncial, $fechaFinal);
        $tmp = [];

        $tarja = Tarja::where([
            'trabajador_id' => $trabajador->id,
            'mes' => $paymentInfo->getMonth(),
            'anio' => $paymentInfo->getYear(),
        ])->first();

        if (!$tarja) {
            return [];
        }

        $tarja = $tarja->toArray();

        for ($i = 1; $i <= 31; $i++)
        {
            array_push($tmp, [
                'fecha'   => $i . '/' . $paymentInfo->getMonth(),
                'horas' => $tarja['dia_' . $i]
            ]);
        }

        return $tmp;
    }

    public function getTarjaSinDigitacion(PaymentInfo $paymentInfo)
    {
        $trabajador = $paymentInfo->getEmployee();

        $fechaIncial = clone $paymentInfo->getPeriod()->firstOfMonth();
        $fechaFinal = $paymentInfo->getTypePaymentId() === 2
            ? clone $paymentInfo->getPeriod()->addDays(14)
            : clone $paymentInfo->getPeriod()->lastOfMonth();

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

            $fecha = $this->diaCortoEspaniol($dia->dayOfWeek) . ' ' . $dia->day . '/' . $dia->month;
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
