<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyDetailPayments;
use App\Repositories\PaymentDetailRepositoryInterface;
use App\Services\ImportCsvService;
use App\Services\PaymentDetailService;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    private $repository;
    private $service;
    private ImportCsvService $importService;

    public function __construct(PaymentDetailRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->service = new PaymentDetailService();
        $this->importService = new ImportCsvService($this->repository);
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

    public function storeMany (Request $request)
    {
        $data = $request->get('data');
        $result = ProcessStoreManyDetailPayments::dispatch($data);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);

        /* $result = $this->service->storeMany($data);
        return response()->json($result); */
    }

    public function import(Request $request)
    {
        $file = $request->file('paymentsDetail');

        return $this->importService->execute($file);
    }
}
