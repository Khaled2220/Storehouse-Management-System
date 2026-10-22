<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;


Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API is working '
    ]);
});

//Route::get('/register', [RegisterController::class,'Registe']);
Route::post('/register', [RegisterController::class, 'register']);

//Route::get('/login',[LoginController::class,'login']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
  Route::apiResource('products', ProductController::class);
});


