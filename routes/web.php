<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Home - Redirect to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Order Management
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order-completed', [OrderController::class, 'completed'])->name('order.completed');
    Route::get('/order-taken', [OrderController::class, 'taken'])->name('order.taken');
    Route::get('/order-delivery', [OrderController::class, 'delivery'])->name('order.delivery');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::put('/order/{order}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');
    Route::post('/order/{order}/taken', [OrderController::class, 'markTaken'])->name('order.taken-mark');
    Route::post('/order/{order}/delivery', [OrderController::class, 'markDelivered'])->name('order.delivery-mark');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
