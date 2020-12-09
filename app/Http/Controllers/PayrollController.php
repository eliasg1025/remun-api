<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    private PayrollService $paymentService;

    public function __construct()
    {
        $this->paymentService = new PayrollService();
    }

    public function getByEmployee(Request $request, $trabajadorId)
    {
        return response()->json([
            'message' => 'Planillas obtenidas',
            'data' => $this->paymentService->getByEmployee($trabajadorId)
        ]);
    }

    public function getPeriods(Request $request)
    {
        return response()->json([
            'message' => 'Periodos obtenidos',
            'data' => $this->paymentService->getPeriods(),
        ]);
    }
}
