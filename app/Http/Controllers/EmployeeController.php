<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepositoryInterface;
use App\Services\ImportCsvService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $repository;
    private ImportCsvService $importService;

    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->importService = new ImportCsvService($this->repository);
    }

    public function payments(Request $request)
    {
        dd($request);
        $employeeId = $request->user->employee->id;
        $employee = $this->repository->find($employeeId);

        foreach ($employee->payments as $payment) {
            $payment->details;
        }
        return $employee;
    }

    public function show($employee)
    {
        return $this->repository->find($employee);
    }

    public function info($employee)
    {
        $instance = $this->repository->find($employee);

        foreach ($instance->payments as $payment) {
            $payment->details;
        }

        return $instance;
    }

    public function store(Request $request)
    {
        return $this->repository->create($request->all());
    }

    public function import(Request $request)
    {
        $file = $request->file('employees');

        return $this->importService->execute($file);
    }
}
