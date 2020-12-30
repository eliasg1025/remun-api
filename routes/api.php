<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AsistenciasController, PaymentController, EmployeeController, PaymentDetailController, UserController, AuthController, EntregasCanastasController, LecturasSueldosController, ObservacionesController, PayrollController, RolController, TarjaController};
use App\Services\LecturasSueldoService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::get('me', [AuthController::class, 'me'])->middleware('api.auth');
    Route::get('roles', [AuthController::class, 'roles'])->middleware('api.auth');
});

Route::group(['prefix' => 'roles'], function() {
    Route::get('/', [RolController::class, 'get'])->middleware('api.auth');
});

Route::group(['prefix' => 'payroll'], function() {
    Route::get('/employee/{trabajadorId}', [PayrollController::class, 'getByEmployee']);
    Route::get('/periods', [PayrollController::class, 'getPeriods']);
});

Route::group(['prefix' => 'payments'], function() {
    Route::get('/', [PaymentController::class, 'all']);
    Route::get('/{id}', [PaymentController::class, 'show'])->where('id', '[0-9]+');
    Route::post('/', [PaymentController::class, 'store']);
    Route::post('/many', [PaymentController::class, 'storeMany']);
    Route::post('/import', [PaymentController::class, 'import']);
});

Route::group(['prefix' => 'employees'], function () {
    Route::get('/me', [EmployeeController::class, 'info'])->middleware('api.auth');
    Route::get('/{id}', [EmployeeController::class, 'show'])->where('id', '[0-9]+')->middleware('api.auth');
    Route::get('/{employee}/payment', [EmployeeController::class, 'getPayment'])->middleware('api.auth');
    Route::get('/{employee}/entregas-canastas', [EmployeeController::class, 'getEntregasCanastas'])->middleware('api.auth');
    Route::post('/', [EmployeeController::class, 'store']);
    Route::post('/many', [EmployeeController::class, 'storeMany']);
    Route::post('/import', [EmployeeController::class, 'import']);
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'get'])->middleware('api.auth');
    Route::post('/create-other', [UserController::class, 'createOtherUser'])->middleware('api.auth');
    Route::post('/sync', [UserController::class, 'sync']);
});

Route::group(['prefix' => 'payments-detail'], function() {
    Route::get('/{id}', [PaymentDetailController::class, 'show']);
    Route::post('/many', [PaymentDetailController::class, 'storeMany']);
    Route::post('/import', [PaymentDetailController::class, 'import']);
});

Route::group(['prefix' => 'tarja'], function() {
    Route::post('/many', [TarjaController::class, 'storeMany']);
});

Route::group(['prefix' => 'asistencias'], function() {
    Route::post('/many', [AsistenciasController::class, 'storeMany']);
});

Route::group(['prefix' => 'lecturas-sueldos'], function() {
    Route::get('/', [LecturasSueldosController::class, 'get']);
    Route::get('/get-cantidad-por-dia', [LecturasSueldosController::class, 'getCantidadPorDia']);
});

Route::group(['prefix' => 'observaciones'], function() {
    Route::get('/', [ObservacionesController::class, 'get'])->middleware('api.auth');
    Route::post('/', [ObservacionesController::class, 'store'])->middleware('api.auth');
});

Route::group(['prefix' => 'entregas-canastas'], function() {
    Route::post('/', [EntregasCanastasController::class, 'store'])->middleware('api.auth');
});

/* Route::group(['prefix' => 'companies'], function () {

}); */

