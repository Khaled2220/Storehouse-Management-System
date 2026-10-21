<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureUserIsAdmin;

// Redirect homepage to login
Route::redirect('/', '/login');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Login
Route::get('/login', [AuthController::class, 'showlogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

// Authenticated users
Route::middleware(['auth'])->group(function () {

    // Admin-only 
    Route::middleware([EnsureUserIsAdmin::class])->group(function () {

        Route::resource('Products', ProductController::class)
            ->except(['index', 'show']);

        Route::resource('Categorios', CategoryController::class)
            ->except(['index', 'show']);

    });

    // Product 
    Route::resource('Products', ProductController::class)
        ->only(['index', 'show']);

    // Category 
    Route::resource('Categorios', CategoryController::class)
        ->only(['index', 'show']);

    // Notification 
    Route::get('/notifications', [
        NotificationController::class,
        'index'
    ])->name('notifications.index');

    Route::patch('/notifications/{id}/read', [
        NotificationController::class,
        'markAsRead'
    ])->name('notifications.read');

    Route::delete('/notifications/{id}', [
        NotificationController::class,
        'destroy'
    ])->name('notifications.destroy');

});


// Route::get('/products', [ProductController::class, 'index'])
//     ->middleware('auth', 'admin');

// Route::get('/Products', function () {
//     $Products = \App\Models\Products::latest()->paginate(50);
//     return view('productview.index', compact('Products'));
// })->name('Products.index')->middleware('auth');

// Route::get('/product/{id}', [ProductController::class, 'show']);

// Route::get('/Categorios', [CategoryController::class, 'index']);