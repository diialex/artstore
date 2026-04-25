<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;


Route::resource('payments', PaymentController::class);
Route::resource('orders', OrderController::class);