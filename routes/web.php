<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Products;

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

    // Products: available to authenticated users


    // Create product page: ProductsPolicy
    Route::get('/Products/create', [ProductController::class, 'create'])
        ->middleware('can:create,' . Products::class)
        ->name('Products.create');


    // Store product: ProductsPolicy
    Route::post('/Products', [ProductController::class, 'store'])
        ->middleware('can:create,' . Products::class)
        ->name('Products.store');


    // List products
    Route::get('/Products', [ProductController::class, 'index'])
        ->name('Products.index');


    // Edit product: ProductsPolicy
    Route::get('/Products/{product}/edit', [ProductController::class, 'edit'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.edit');


    // Update product: ProductsPolicy
    Route::put('/Products/{product}', [ProductController::class, 'update'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.update');

    Route::patch('/Products/{product}', [ProductController::class, 'update'])
        ->whereNumber('product')
        ->middleware('can:update,product')
        ->name('Products.update.patch');


    // Delete product: ProductsPolicy
    Route::delete('/Products/{product}', [ProductController::class, 'destroy'])
        ->whereNumber('product')
        ->middleware('can:delete,product')
        ->name('Products.destroy');


    // Show product
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


    // Notifications
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


//require __DIR__ . '/auth.php';
