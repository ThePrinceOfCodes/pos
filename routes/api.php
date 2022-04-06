<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CashierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login']);

Route::get('company-details', [CashierController::class, 'organizationDetails']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/categories', [CashierController::class, 'getCategories']);

    Route::get('/products', [CashierController::class, 'getProducts']);

    Route::get('/payment-methods', [CashierController::class, 'paymentMethods']);

    Route::post('/make-sales', [CashierController::class, 'makeSales']);

    Route::get('/get-sales/{sale}', [CashierController::class, 'getSales']);

    Route::get('/close-shift/{sale}', [CashierController::class, 'closeShift']);

});
