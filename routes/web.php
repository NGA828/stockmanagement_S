<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only: Full User Management and System Control
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        // Admin can delete everything - using standard names
        Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    // Stock Manager & Admin: Inventory & Procurement
    Route::middleware('role:admin,stock_manager')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['destroy']);
        Route::resource('items', ItemController::class)->except(['destroy']);
        Route::resource('orders', OrderController::class)->except(['destroy']);
        Route::resource('reports', ReportController::class);
    });

    // Warehouse Staff & Above: Day-to-day operations
    Route::middleware('role:admin,stock_manager,warehouse_staff')->group(function () {
        // Warehouse staff can only see items and log basic movements
        Route::get('items', [ItemController::class, 'index'])->name('items.index');
        Route::get('transactions', [InventoryTransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/create', [InventoryTransactionController::class, 'create'])->name('transactions.create');
        Route::post('transactions', [InventoryTransactionController::class, 'store'])->name('transactions.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
