<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentRepositoryInterface;
use App\Services\ImportCsvService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $repository;
    private ImportCsvService $importService;

    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->importService = new ImportCsvService($this->repository);
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

    public function import(Request $request)
    {
        $file = $request->file('payments');

        return $this->importService->execute($file);
    }
}
