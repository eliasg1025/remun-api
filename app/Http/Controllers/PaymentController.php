<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyPayments;
use App\Repositories\PaymentRepositoryInterface;
use App\Services\EmployesService;
use App\Services\ImportCsvService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $repository;
    private EmployesService $employeeService;
    private PaymentService $paymentService;
    private ImportCsvService $importService;

    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->repository     = $repository;
        $this->employeeService = new EmployesService();
        $this->paymentService = new PaymentService();
        $this->importService  = new ImportCsvService($this->repository);
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function show($payment)
    {
        return $this->repository->find($payment);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return $this->repository->create($data);
    }

    public function storeMany(Request $request)
    {
        $data = $request->get('data');
        $result = ProcessStoreManyPayments::dispatch($data);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);
    }

    public function import(Request $request)
    {
        $file = $request->file('payments');

        return $this->importService->execute($file);
    }
}
