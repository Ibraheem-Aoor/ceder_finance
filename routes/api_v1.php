<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Invoice\InvoiceController;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('invoice')->group(function () {
        Route::post('send' , [InvoiceController::class , 'submitInvoice']);
        Route::get('fetch' , [InvoiceController::class, 'fetchInvoices']);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('login' , [LoginController::class, 'login']);
    Route::post('logout' , [LoginController::class, 'logout'])->middleware('auth:sanctum');
});
