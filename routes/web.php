<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\EnsureUserIsAdmin; 

Route::redirect('/', '/login');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);




Route::middleware(['auth'])->group(function () {
  
   Route::middleware([EnsureUserIsAdmin::class])->group(function () {
      Route::resource('Products', ProductController::class)->except(['index', 'show']);
      Route::resource('Categorios', CategoryController::class)->except(['index', 'show']);
   });
    Route::resource('Products', ProductController::class)->only(['index', 'show']);
    Route::resource('Categorios', CategoryController::class)->only(['index', 'show']); 

});



//Route::get('/products',[ProductController::class,'index'])->middleware('auth','admin');

//Route::get('/Products', function() {
//    $products = \App\Models\Products::latest()->paginate(50);
//    return view('productview.index', compact('products'));
//})->name('Products.index')->middleware('auth');


//Route::View('/register', [AuthController::class, 'register']);
//Route::post('/register', [AuthController::class, 'register']);



//Route::get('/product/{id}', [ProductController::class, 'show']);


//Route::get('/products',[ProductController::class,'index']);
//Route::get('/products',[ProductController::class,'create']);
//Route::post('/products',[ProductController::class,'store']);
//Route::get('/products',[ProductController::class,'show']);
//Route::delete('/products',[ProductController::class,'destroy']);

//Route::get('/Categorios',[CategoryController::class,'index']);
//Route::get('/Categorios',[CategoryController::class,'create']);
//Route::post('/Categorios',[CategoryController::class,'store']);
//Route::get('/Categorios',[CategoryController::class,'show']);
//Route::delete('/Categorios',[CategoryController::class,'destroy']);