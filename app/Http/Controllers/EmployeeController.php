<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyEmployees;
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

    public function storeMany(Request $request)
    {
        $data = $request->get('data');
        $result = ProcessStoreManyEmployees::dispatch($data);
        return response()->json([
            'message' => 'Proceso en cola'
        ]);
    }

    public function getPayment(Employee $employee, Request $request)
    {
        $usuario    = $request->get('user');
        $periodo    = Carbon::parse($request->query('period'));
        $tipoPagoId = $request->query('paymentTypeId');
        $seguro     = $request->query('seguro');
        $empresaId  = $request->query('empresaId') ?? 0;
        $paymentInfo    = new PaymentInfo($employee, $periodo, $tipoPagoId, $empresaId);

        $employee           = $this->employeeService->getPayment($paymentInfo);
        $existTwoPayments   = $this->employeeService->existTwoPayments($paymentInfo);

        if ($employee->sueldo_bruto >= 2000 && $usuario->rol->id !== 4) {
            return response()->json(['message' => 'Trabajador restringido'], 401);
        }

        //$this->lecturasService->store($periodo, $tipoPagoId, $usuario->sub, $employee->payment->id);

        return [
            'message'       => $existTwoPayments ? 'Existe dos pagos del trabajador para el periodo ' . $periodo->format('m/Y') : 'Pago encontrado',
            'show_message'  => $existTwoPayments,
            'data'          => $employee
        ];
    }

    public function getEntregasCanastas(Employee $employee, Request $request)
    {
        $usuario = $request->get('user');

        $employee = $this->employeeService->getUltimaEntregaCanasta($employee);

        $message = is_null($employee->entrega_canasta)
            ? 'Trabajador obtenido'
            : 'Ya se entregó canasta';

        return response()->json([
            'message' => $message,
            'data' => $employee
        ]);
    }

    public function info(Request $request)
    {
        $periodo    = Carbon::parse($request->query('period'));
        $tipoPagoId = $request->query('paymentTypeId');
        $user       = $request->get('user');

        $employee = $this->repository->find($user->trabajador->id);
        $paymentInfo = new PaymentInfo($employee, $periodo, $tipoPagoId, 0);
        $employee = $this->employeeService->getPayment($paymentInfo);

        return $employee;
    }

    public function import(Request $request)
    {
        $file = $request->file('employees');

        return $this->importService->execute($file);
    }
}
