<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

#USER CRUD

Route::get('/users', [UsersController::class, 'index']);

Route::get('/createUsers', [UsersController::class, 'create'])->name('users.create');

Route::post('/createUsers', [UsersController::class, 'store'])->name('users.store');
