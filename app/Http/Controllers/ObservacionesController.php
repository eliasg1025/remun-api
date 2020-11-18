<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObservacionesPost;
use Illuminate\Http\Request;
use App\Services\ObservacionesService;

class ObservacionesController extends Controller
{
    public ObservacionesService $observacionesService;

    public function __construct()
    {
        $this->observacionesService = new ObservacionesService();
    }

    public function store(ObservacionesPost $request)
    {
        $usuario = $request->get('user');

        $result = $this->observacionesService->store(
            $request->incidencia_con, $request->objeto_incidencia, $request->comentario, $usuario->sub, $request->pago_id, $request->tipo_pago_id
        );

        return response()->json([
            'message' => 'Observación creada correactamente',
            'data' => $result
        ]);
    }

    public function get(Request $request)
    {
        $usuario = $request->get('user');

        $validatedData = $request->validate([
            'pago_id' => 'exists:App\Models\PaymentType,id|numeric',
            'tipo_pago_id' => 'exists:App\Models\Payment,id|numeric',
            'get_all' => 'required|bool'
        ]);

        $result = $this->observacionesService->get($usuario->sub, $validatedData['pago_id'] ?? 0, $request['tipo_pago_id'] ?? 0, $request['get_all']);

        return response()->json([
            'message'   => 'Data obtenida',
            'data'      => $result
        ]);
    }
}
