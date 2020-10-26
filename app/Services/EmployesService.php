<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EmployesService
{
    /* public EmployeeRepositoryInterface $repository; */

    public function __construct(/* $repository */)
    {
        /* $this->repository = $repository; */
    }

    public function storeMany(array $data)
    {
        $counter = 0;
        foreach ($data as $row) {
            $nombre_tabla = 'trabajador_';
            $trabajador = [
                'id'               => $row[$nombre_tabla . 'id'],
                'nombre'           => $row[$nombre_tabla . 'nombre'],
                'apellido_paterno' => $row[$nombre_tabla . 'apellido_paterno'],
                'apellido_materno' => $row[$nombre_tabla . 'apellido_materno'],
                'jornal'           => $row[$nombre_tabla . 'jornal']
            ];

            $counter += DB::table('trabajadores')->updateOrInsert(['id' => $trabajador['id']], $trabajador);
        }
        return $counter;
    }
}
