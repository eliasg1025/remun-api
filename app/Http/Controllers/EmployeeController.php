<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepositoryInterface;
use App\Services\AsistenciasService;
use App\Services\ImportCsvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    private $repository;
    private ImportCsvService $importService;
    private AsistenciasService $asistenciasService;

    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->importService = new ImportCsvService($this->repository);
        $this->asistenciasService = new AsistenciasService();
    }

    public function payments(Request $request)
    {
        $employeeId = $request->get('user')->username;
        $employee = $this->repository->find($employeeId);

        foreach ($employee->payments as $payment) {
            $payment->details;
        }

        $employee->tarja = $employee->jornal
            ? $this->asistenciasService->getTarjaConDigitacion($employee)
            : $this->asistenciasService->getTarjaSinDigitacion($employee);
        //$employee->asistencias;
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
