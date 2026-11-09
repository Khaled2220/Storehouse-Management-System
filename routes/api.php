
<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SupplierController;
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

    Route::get('/suppliers', [SupplierController::class, 'index']);

    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);

    Route::post('/suppliers', [SupplierController::class, 'store'])
        ->middleware('can:create,App\Models\Supplier');

    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('can:update,supplier');

    Route::patch('/suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('can:update,supplier');

    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])
        ->middleware('can:delete,supplier');
});
