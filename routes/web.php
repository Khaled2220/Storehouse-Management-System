<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Products;


Route::redirect('/', '/login');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showlogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');    

Route::middleware(['auth'])->group(function () {

    Route::get('/Products', [ProductController::class, 'index'])
        ->name('Products.index');

    Route::get('/Products/create', [ProductController::class, 'create'])
        ->middleware('can:create,' . Products::class)
        ->name('Products.create');

    Route::post('/Products', [ProductController::class, 'store'])
        ->middleware('can:create,' . Products::class)
        ->name('Products.store');

    Route::get('/Products/{product}/edit', [ProductController::class, 'edit'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.edit');

    Route::put('/Products/{product}', [ProductController::class, 'update'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.update');

    Route::patch('/Products/{product}', [ProductController::class, 'update'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.update.patch');

    Route::delete('/Products/{product}', [ProductController::class, 'destroy'])
        ->whereNumber('product')
        ->middleware('can:delete,product')
        ->name('Products.destroy');

    Route::get('/Products/{product}', [ProductController::class, 'show'])
        ->whereNumber('product')
        ->name('Products.show');

    Route::middleware([EnsureUserIsAdmin::class])->group(function () {

        Route::resource('Categorios', CategoryController::class)
            ->except(['index', 'show'])
            ->parameters([
                'Categorios' => 'category',
            ]);
    });
    Route::resource('Categorios', CategoryController::class)
        ->only(['index', 'show'])
        ->parameters([
            'Categorios' => 'category',
        ]);

    Route::middleware([EnsureUserIsAdmin::class])->group(function () {

        Route::resource('users', UserController::class)
            ->names([
                'index' => 'user.index',
                'create' => 'user.create',
                'store' => 'user.store',
                'show' => 'user.show',
                'edit' => 'user.edit',
                'update' => 'user.update',
                'destroy' => 'user.destroy',
            ]);
    });
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
    Route::get('/Profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::get('/Profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/Profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/Profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});