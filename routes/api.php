<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API is working',
    ]);
});

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('throttle:5,1');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:5,1');

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('can:create,App\Models\Product');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->middleware('can:update,product');

    Route::patch('/products/{product}', [ProductController::class, 'update'])
        ->middleware('can:update,product');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:delete,product');

});
