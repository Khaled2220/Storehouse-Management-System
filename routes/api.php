<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\StockMovementController;
use App\Http\Controllers\API\SupplierController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('throttle:5,1');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:5,1');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);

    Route::put('/products/{product}', [ProductController::class, 'update']);

    Route::patch('/products/{product}', [ProductController::class, 'update']);

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:delete,product');

    Route::get('/suppliers', [SupplierController::class, 'index']);

    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);

    Route::post('/suppliers', [SupplierController::class, 'store']);

    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']);

    Route::patch('/suppliers/{supplier}', [SupplierController::class, 'update']);

    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])
        ->middleware('can:delete,supplier');

    Route::get('/stock-movements', [StockMovementController::class, 'index'])
        ->middleware('can:viewAny,App\Models\StockMovement')
        ->name('api.stock-movements.index');

    Route::post('/stock-movements', [StockMovementController::class, 'store'])
        ->name('api.stock-movements.store');
});
