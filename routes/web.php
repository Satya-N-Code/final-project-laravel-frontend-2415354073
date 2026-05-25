<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;

// Otomatis arahkan halaman utama ke halaman customers untuk sementara
Route::redirect('/', '/customers');

// Route untuk menampilkan halaman data customer
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/subscriptions', [SubscriptionController::class, 'index']);