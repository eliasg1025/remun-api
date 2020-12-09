<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EntregaCanasta;
use App\Models\User;

class EntregasCanastasService
{
    public function store(User $user, Employee $employee)
    {
        try {
            $entregaCanasta = new EntregaCanasta();
            $entregaCanasta->trabajador_id = $employee->id;
            $entregaCanasta->usuario_id = $user->id;
            $entregaCanasta->empresa_id = $employee->empresa_id;
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
}
