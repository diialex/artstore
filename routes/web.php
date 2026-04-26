<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

// TEMPORAL QUITAR ESTA RUTA
Route::redirect('/', '/categories');

# CATEGORIES CRUD
Route::resource('categories', CategoryController::class);

# PRODUCTS CRUD
Route::resource('products', ProductController::class);

#USER CRUD

Route::get('/users', [UsersController::class, 'index']);

Route::get('/createUsers', [UsersController::class, 'create'])->name('users.create');

Route::post('/createUsers', [UsersController::class, 'store'])->name('users.store');

Route::get("/users/{id}", [UsersController::class, 'show'])->name('users.show')->where('id', '[0-9]+');

Route::get("/users/{username}", [UsersController::class, 'show_by_username'])->name('users.show_by_name');

Route::get('/editUsers/{id}', [UsersController::class, 'edit'])->name('users.edit');

Route::put('/updateUsers/{id}', [UsersController::class, 'update'])->name('users.update');

Route::delete('/deleteUsers/{id}', [UsersController::class, 'destroy'])->name('users.delete');
