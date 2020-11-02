<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyAsistencias;
use App\Services\AsistenciasService;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new AsistenciasService();
    }

    public function storeMany(Request $request)
    {
        $data = [
            'data' => $request->get('data'),
            'mes'  => $request->get('mes'),
            'anio' => $request->get('anio')
        ];
        //$result = ProcessStoreManyAsistencias::dispatch($data['data']);

        $this->service->storeMany($data['data']);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);
    }
}
