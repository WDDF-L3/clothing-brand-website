<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home / Shop
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/shop/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{category:slug}', [ProductController::class, 'category'])->name('products.category');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{rowId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/place', [CheckoutController::class, 'place'])->name('place');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

// ─── Admin ────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (no middleware)
    Route::get('/login',  [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    // Protected routes
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/',                           [AdminProductController::class, 'index'])->name('index');
            Route::get('/create',                     [AdminProductController::class, 'create'])->name('create');
            Route::post('/',                          [AdminProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit',             [AdminProductController::class, 'edit'])->name('edit');
            Route::put('/{product}',                  [AdminProductController::class, 'update'])->name('update');
            Route::delete('/{product}',               [AdminProductController::class, 'destroy'])->name('destroy');
            Route::patch('/{product}/toggle-active',  [AdminProductController::class, 'toggleActive'])->name('toggle-active');
        });

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/',              [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}',       [AdminOrderController::class, 'show'])->name('show');
            Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
            Route::delete('/{order}',    [AdminOrderController::class, 'destroy'])->name('destroy');
        });

        // Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/',              [AdminCategoryController::class, 'index'])->name('index');
            Route::post('/',             [AdminCategoryController::class, 'store'])->name('store');
            Route::put('/{category}',    [AdminCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('destroy');
        });
    });
});
