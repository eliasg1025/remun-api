<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Repositories\EmployeeRepositoryInterface;
use App\Services\AsistenciasService;
use App\Services\EmployesService;
use App\Services\ImportCsvService;
use App\Services\LecturasSueldoService;
use App\Utils\PaymentInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    private $repository;
    private ImportCsvService $importService;
    private EmployesService $employeeService;
    private LecturasSueldoService $lecturasService;

    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->importService = new ImportCsvService($this->repository);
        $this->employeeService = new EmployesService();
        $this->lecturasService = new LecturasSueldoService();
    }

    public function show($employee)
    {
        return $this->repository->find($employee);
    }

    public function store(Request $request)
    {
        return $this->repository->create($request->all());
    }

    public function getPayment(Employee $employee, Request $request)
    {
        $usuario    = $request->get('user');
        $periodo    = Carbon::parse($request->query('period'));
        $tipoPagoId = $request->query('paymentTypeId');
        $seguro     = $request->query('seguro');

        $paymentInfo    = new PaymentInfo($employee, $periodo, $tipoPagoId);
        $employee       = $this->employeeService->getPayment($paymentInfo);

        $this->lecturasService->store($periodo, $tipoPagoId, $usuario->sub);

        return $employee;
    }

    public function info(Request $request)
    {
        $periodo    = Carbon::parse($request->query('period'));
        $tipoPagoId = $request->query('paymentTypeId');
        $user       = $request->get('user');

        $employee = $this->repository->find($user->trabajador->id);
        $paymentInfo = new PaymentInfo($employee, $periodo, $tipoPagoId);
        $employee = $this->employeeService->getPayment($paymentInfo);

        return $employee;
    }

    public function import(Request $request)
    {
        $file = $request->file('employees');

        return $this->importService->execute($file);
    }
}
