<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentRepositoryInterface;
use App\Services\ImportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    private $repository;
    private ImportService $importService;

    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->importService = new ImportService($this->repository);
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function show($post)
    {
        return $this->repository->find($post);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return $this->repository->create($data);
    }

    public function import(Request $request)
    {
        $file = $request->file('liquidaciones');

        return $this->importService->execute($file);
    }
}
