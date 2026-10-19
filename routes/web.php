<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureUserIsAdmin;

// Redirect the home page to login
Route::redirect('/', '/login');

// Registration routes
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Login routes
Route::get('/login', [AuthController::class, 'showlogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {

    // Admin-only routes for creating, editing and deleting
    Route::middleware([EnsureUserIsAdmin::class])->group(function () {

        Route::resource('Products', ProductController::class)
            ->except(['index', 'show']);

        Route::resource('Categorios', CategoryController::class)
            ->except(['index', 'show']);
    });

    // Product routes available to authenticated users
    Route::resource('Products', ProductController::class)
        ->only(['index', 'show']);

    // Category routes available to authenticated users
    Route::resource('Categorios', CategoryController::class)
        ->only(['index', 'show']);

    // Display notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // Mark a notification as read
    Route::patch('/notifications/{id}/read', [
        NotificationController::class,
        'markAsRead'
    ])->name('notifications.read');
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