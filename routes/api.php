<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ PaymentController };
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


Route::group(['prefix' => 'payments'], function() {
    Route::get('/', [PaymentController::class, 'all']);
    Route::get('/{id}', [PaymentController::class, 'show'])->where('id', '[0-9]+');
    Route::post('/', [PaymentController::class, 'store']);
    Route::post('/import', [PaymentController::class, 'import']);
});
