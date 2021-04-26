<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EntregaCanasta;
use App\Models\User;

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
}
