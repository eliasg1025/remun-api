<?php

namespace App\Http\Controllers;

use App\Services\LecturasSueldoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturasSueldosController extends Controller
{
    public LecturasSueldoService $lecturasSueldosService;

    public function __construct()
    {
        $this->lecturasSueldosService = new LecturasSueldoService();
    }

    public function get(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        return $this->lecturasSueldosService->get($desde, $hasta);
    }

    public function getCantidadPorDia(Request $request)
    {
        return $this->lecturasSueldosService->getCantidadPorDia();
    }
}
