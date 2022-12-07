<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
//API route for login user
Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/profile', function(Request $request) {
            return auth()->user();
        });
    
            // API route for logout user
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang', [BarangController::class, 'postBarang']);
        Route::put('/barang/{id}', [BarangController::class, 'updateBarang']);
        Route::delete('/barang/{id}', [BarangController::class, 'deleteBarang']);
        Route::get('/barang/{id}', [BarangController::class, 'getById']);

        Route::get('/customer', [CustomerController::class, 'index']);
        Route::post('/customer', [CustomerController::class, 'postCustomer']);
        Route::put('/customer/{id}', [CustomerController::class, 'updateCustomer']);
        Route::delete('/customer/{id}', [CustomerController::class, 'deleteCustomer']);
        Route::get('/customer/{id}', [CustomerController::class, 'getById']);
    
        // API route for logout user
        Route::post('/logout', [AuthController::class, 'logout']);
    });
