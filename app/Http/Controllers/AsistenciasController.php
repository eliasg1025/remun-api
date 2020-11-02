<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyAsistencias;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
    public function __construct()
    {

    }

    public function storeMany(Request $request)
    {
        $data = [
            'data' => $request->get('data'),
            'mes'  => $request->get('mes'),
            'anio' => $request->get('anio')
        ];
        $result = ProcessStoreManyAsistencias::dispatch($data['data']);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);
    }
}
