<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyTarja;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class TarjaController extends Controller
{
    public function storeMany(Request $request)
    {
        $data = $request->get('data');
        ProcessStoreManyTarja::dispatch([
            'data' => $request->get('data'),
            'mes'  => $request->get('mes'),
            'anio' => $request->get('anio')
        ]);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);
    }
}