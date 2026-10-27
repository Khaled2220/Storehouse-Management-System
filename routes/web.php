<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Products;

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

    // Products: create
    Route::get('/Products/create', [ProductController::class, 'create'])
        ->middleware('can:create,' . Products::class)
        ->name('Products.create');

    // Products: store
    Route::post('/Products', [ProductController::class, 'store'])
        ->middleware('can:create,' . Products::class)
        ->name('Products.store');

    // Products: index
    Route::get('/Products', [ProductController::class, 'index'])
        ->name('Products.index');

    // Products: edit
    Route::get('/Products/{product}/edit', [ProductController::class, 'edit'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.edit');

    // Products: update
    Route::put('/Products/{product}', [ProductController::class, 'update'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.update');

    // Products: update using PATCH
    Route::patch('/Products/{product}', [ProductController::class, 'update'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.update.patch');

    // Products: delete
    Route::delete('/Products/{product}', [ProductController::class, 'destroy'])
        ->whereNumber('product')
        ->middleware('can:delete,product')
        ->name('Products.destroy');

    // Products: show
    Route::get('/Products/{product}', [ProductController::class, 'show'])
        ->whereNumber('product')
        ->name('Products.show');

    // Categories: admin-only management
    Route::middleware([EnsureUserIsAdmin::class])->group(function () {
        Route::resource('Categorios', CategoryController::class)
            ->except(['index', 'show']);
    });

    // Categories: available to authenticated users
    Route::resource('Categorios', CategoryController::class)
        ->only(['index', 'show']);

    // Notifications: admin only
    Route::middleware([EnsureUserIsAdmin::class])->group(function () {

        Route::get('/notifications', [
            NotificationController::class,
            'index',
        ])->name('notifications.index');

        Route::patch('/notifications/{id}/read', [
            NotificationController::class,
            'markAsRead',
        ])->name('notifications.read');

        Route::delete('/notifications/{id}', [
            NotificationController::class,
            'destroy',
        ])->name('notifications.destroy');
    });
});

