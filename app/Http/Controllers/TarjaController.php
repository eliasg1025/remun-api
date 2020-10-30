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
        ProcessStoreManyTarja::dispatch($data);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);
    }
}
