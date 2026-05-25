<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;

// Otomatis arahkan halaman utama ke halaman customers untuk sementara
Route::redirect('/', '/customers');

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::patch('/customers/{id}/status', [CustomerController::class, 'updateStatus'])->name('customers.updateStatus');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/subscriptions', [SubscriptionController::class, 'index']);