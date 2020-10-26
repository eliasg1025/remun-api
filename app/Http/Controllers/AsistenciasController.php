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
        $data = $request->get('data');
        $result = ProcessStoreManyAsistencias::dispatch($data);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);
    }
}
