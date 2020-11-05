<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyTarja;
use App\Services\TarjaService;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class TarjaController extends Controller
{
    public function storeMany(Request $request)
    {
        $data = [
            'data' => $request->get('data'),
            'mes'  => $request->get('mes'),
            'anio' => $request->get('anio'),
            'empresaId' => $request->get('empresaId'),
        ];

        /* ProcessStoreManyTarja::dispatch($data);
        return response()->json([
            'message' => 'Proceso en cola'
        ]); */
        $service = new TarjaService();
        try {
            $service->storeMany($data);
            return response()->json([
                'message' => 'Proceso en cola'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
