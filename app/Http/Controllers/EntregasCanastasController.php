<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Services\EntregasCanastasService;
use Illuminate\Http\Request;

class EntregasCanastasController extends Controller
{
    private EntregasCanastasService $entregasCanastasService;

    public function __construct()
    {
        $this->entregasCanastasService = new EntregasCanastasService();
    }

    public function store(Request $request)
    {
        $usuario = User::find($request->get('user')->sub);
        $trabajadorId = $request->get('employee_id');

        $employee = Employee::find($trabajadorId);

        $result = $this->entregasCanastasService->store($usuario, $employee);

        if (isset($result['error'])) {
            unset($result['error']);
            return response()->json($result, 400);
        }

        return response()->json($result, 201);
    }
}
