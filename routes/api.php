<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ PaymentController, EmployeeController, PaymentDetailController, UserController, AuthController };
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
});

Route::group(['prefix' => 'payments'], function() {
    Route::get('/', [PaymentController::class, 'all']);
    Route::get('/{id}', [PaymentController::class, 'show'])->where('id', '[0-9]+');
    Route::post('/', [PaymentController::class, 'store']);
    Route::post('/import', [PaymentController::class, 'import']);
});

Route::group(['prefix' => 'employees'], function () {
    Route::post('/', [EmployeeController::class, 'store']);
    Route::get('/{id}', [EmployeeController::class, 'show'])->where('id', '[0-9]+')->middleware('api.auth');
    Route::post('/import', [EmployeeController::class, 'import']);
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/sync', [UserController::class, 'sync']);
});

Route::group(['prefix' => 'payments-detail'], function() {
    Route::get('/{id}', [PaymentDetailController::class, 'show']);
    Route::post('/import', [PaymentDetailController::class, 'import']);
});

Route::group(['prefix' => 'companies'], function () {

});

