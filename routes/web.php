<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Models\Supplier;

Route::redirect('/', '/login');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::resource('products', ProductController::class)
        ->middlewareFor('create', 'can:create,'.Product::class)
        ->middlewareFor('store', 'can:create,'.Product::class)
        ->middlewareFor('edit', 'can:update,product')
        ->middlewareFor('update', 'can:update,product')
        ->middlewareFor('destroy', 'can:delete,product');

    Route::resource('suppliers', SupplierController::class)
        ->middlewareFor('create', 'can:create,'.Supplier::class)
        ->middlewareFor('store', 'can:create,'.Supplier::class)
        ->middlewareFor('edit', 'can:update,supplier')
        ->middlewareFor('update', 'can:update,supplier')
        ->middlewareFor('destroy', 'can:delete,supplier');    

    Route::middleware([EnsureUserIsAdmin::class])->group(function () {
        Route::resource('categories', CategoryController::class)
            ->except(['index', 'show']);
    });

    Route::resource('categories', CategoryController::class)
        ->only(['index', 'show']);

    Route::middleware([EnsureUserIsAdmin::class])->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::middleware([EnsureUserIsAdmin::class])->group(function () {
        Route::get('/notifications', [
            NotificationController::class,
            'index',
        ])->name('notifications.index');

        Route::patch('/notifications/{notification}/read', [
            NotificationController::class,
            'markAsRead',
        ])->name('notifications.read');

        Route::delete('/notifications/{notification}', [
            NotificationController::class,
            'destroy',
        ])->name('notifications.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
