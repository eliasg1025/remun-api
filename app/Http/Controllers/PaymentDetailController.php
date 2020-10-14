<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentDetailRepositoryInterface;
use App\Services\ImportCsvService;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    private $repository;
    private ImportCsvService $importService;

    public function __construct(PaymentDetailRepositoryInterface $repository)
    {
        $this->repository = $repository;
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

    public function import(Request $request)
    {
        $file = $request->file('paymentsDetail');

        return $this->importService->execute($file);
    }
}
