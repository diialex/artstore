<?php

use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AddressController;


Route::resource('payments', PaymentController::class);
Route::resource('orders', OrderController::class);
Route::resource('orderitems', OrderItemController::class);

Route::get('/', function () {
    return view('welcome');
});

#USER

Route::get('/users', [UsersController::class, 'index'])->name('users.index');

Route::get('/createUsers', [UsersController::class, 'create'])->name('users.create');

Route::post('/createUsers', [UsersController::class, 'store'])->name('users.store');

Route::get("/users/{id}", [UsersController::class, 'show'])->name('users.show')->where('id', '[0-9]+');

Route::get("/users/{username}", [UsersController::class, 'show_by_username'])->name('users.show_by_name');

Route::get('/editUsers/{id}', [UsersController::class, 'edit'])->name('users.edit');

Route::put('/updateUsers/{id}', [UsersController::class, 'update'])->name('users.update');

Route::delete('/deleteUsers/{id}', [UsersController::class, 'destroy'])->name('users.delete');

#ROLE

Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');

Route::get('/createRoles', [RolesController::class, 'create'])->name('roles.create');

Route::post('/createRoles', [RolesController::class, 'store'])->name('roles.store');

Route::get("/roles/{id}", [RolesController::class, 'show'])->name('roles.show')->where('id', '[0-9]+');

Route::get("/roles/{username}", [RolesController::class, 'show_by_name'])->name('roles.show_by_name');

Route::get('/editRoles/{id}', [RolesController::class, 'edit'])->name('roles.edit');

Route::put('/updateRoles/{id}', [RolesController::class, 'update'])->name('roles.update');

Route::delete('/deleteRoles/{id}', [RolesController::class, 'destroy'])->name('roles.delete');

#ADDRESS

Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');

Route::get('/createAddress', [AddressController::class, 'create'])->name('addresses.create');

Route::post('/createAddress', [AddressController::class, 'store'])->name('addresses.store');

Route::post("/addresses/{id}}", [AddressController::class, 'show'])->name('addresses.show');

Route::get('/editAddress/{id}', [AddressController::class, 'edit'])->name('addresses.edit');

Route::put('/updateAddress/{id}', [AddressController::class, 'update'])->name('addresses.update');

Route::delete('/deleteAddress/{id}', [AddressController::class, 'destroy'])->name('addresses.delete');
