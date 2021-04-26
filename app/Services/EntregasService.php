<?php

namespace App\Services;

use App\Models\Entrega;

class EntregasService
{
    public function getCurrentEntrega(): Entrega
    {
        return Entrega::where('activo', true)->first();
    }
}
