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
        return $this->paymentService->getByEmployee($trabajadorId);
    }
}
