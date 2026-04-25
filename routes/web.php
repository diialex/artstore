<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

#USER CRUD

Route::get('/users', [UsersController::class, 'index']);

Route::get('/createUsers', [UsersController::class, 'create'])->name('users.create');

Route::post('/createUsers', [UsersController::class, 'store'])->name('users.store');

Route::get("/users/{id}", [UsersController::class, 'show'])->name('users.show')->where('id', '[0-9]+');

Route::get("/users/{username}", [UsersController::class, 'show_by_username'])->name('users.show_by_name');

Route::get('/editUsers/{id}', [UsersController::class, 'edit'])->name('users.edit');

Route::put('/updateUsers/{id}', [UsersController::class, 'update'])->name('users.update');

Route::delete('/deleteUsers/{id}', [UsersController::class, 'destroy'])->name('users.delete');
