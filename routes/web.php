<?php

use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Models\Role;
use App\Models\Address;

#VISTAS
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paymentSuccess', [StripeController::class, ])->name('payments.success');
Route::get('/paymentError', [StripeController::class, ])->name('payments.cancel');

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('home', function(){
    return view('auth.dashboard');
})->middleware(['auth','verified'])->name('home'); //Es necesario verificar el email para acceder al dashboard (Protegido por el middleware 'verified')

#USER CRUD

Route::get('/users', [UsersController::class, 'index'])
    ->name('users.index');

Route::get('/users/create', [UsersController::class, 'create'])
    ->name('users.create');

Route::post('/users', [UsersController::class, 'store'])
    ->name('users.store');

Route::get("/users/{username}", [UsersController::class, 'show'])
    ->name('users.show');

Route::get('/users/{username}/edit', [UsersController::class, 'edit'])
    ->name('users.edit');

Route::put('/users/{id}', [UsersController::class, 'update'])
    ->name('users.update');

Route::delete('/users/{id}', [UsersController::class, 'delete'])
    ->name('users.delete');

#ROLE

Route::get('/roles', [RolesController::class, 'index'])
    ->name('roles.index');
    /*->can('viewAny', Role::class);*/

Route::get('/roles/create', [RolesController::class, 'create'])
    ->name('roles.create');

Route::post('/roles', [RolesController::class, 'store'])
    ->name('roles.store');

Route::get("/roles/{role}", [RolesController::class, 'show'])
    ->name('roles.show');

Route::get("/roles/{role}/edit", [RolesController::class, 'edit'])
    ->name('roles.edit');

Route::put('/roles/{role}', [RolesController::class, 'update'])
    ->name('roles.update');

Route::delete('/roles/{role}', [RolesController::class, 'destroy'])
    ->name('roles.delete');

#ADDRESS

Route::get('/addresses', [AddressController::class, 'index'])
    ->name('addresses.index')
    /*->can('viewAny', Address::class)*/;

Route::get('/addresses/create', [AddressController::class, 'create'])
    ->name('addresses.create')
    /*->can('create', Address::class)*/;

Route::post('/addresses', [AddressController::class, 'store'])
    ->name('addresses.store')
    /*->can('create', Address::class)*/;

Route::get("/addresses/user/{username}", [UsersController::class, 'showAddresses'])
    ->name('addresses.show');

Route::get('/editAddress/{address}', [AddressController::class, 'edit'])
    ->name('addresses.edit')
    /*->can('update', 'address')*/;

Route::put('/updateAddress/{address}', [AddressController::class, 'update'])
    ->name('addresses.update')
    /*->can('update', 'address')*/;

Route::delete('/deleteAddress/{address}', [AddressController::class, 'delete'])
    ->name('addresses.delete')
    /*->can('delete', 'address')*/;

Route::post('/addProduct/{product}', [OrderController::class, 'addProducttoOrder'])
    ->name('orders.addProduct');

#CATEGORIES
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index')
    /*->can('viewAny', Category::class)*/;

Route::get('/categories/create', [CategoryController::class, 'create'])
    ->name('categories.create')
    /*->can('create', Category::class)*/;

Route::post('/categories', [CategoryController::class, 'store'])
    ->name('categories.store')
    /*->can('create', Category::class)*/;

Route::get("/categories/{category}", [CategoryController::class, 'show'])
    ->name('categories.show')
    /*->can('view', 'category')*/;

Route::get('/editCategory/{category}', [CategoryController::class, 'edit'])
    ->name('categories.edit')
    /*->can('update', 'category')*/;

Route::put('/updateCategory/{category}', [CategoryController::class, 'update'])
    ->name('categories.update')
    /*->can('update', 'category')*/;

Route::delete('/deleteCategory/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.delete')
    /*->can('delete', 'category')*/;

#PRODUCTS
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index')
    /*->can('viewAny', Product::class)*/;

Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create')
    /*->can('create', Product::class)*/;

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store')
    /*->can('create', Product::class)*/;

Route::get("/products/{product}", [ProductController::class, 'show'])
    ->name('products.show')
    /*->can('view', 'product')*/;

Route::get('/editProduct/{product}', [ProductController::class, 'edit'])
    ->name('products.edit')
    /*->can('update', 'product')*/;

Route::put('/updateProduct/{product}', [ProductController::class, 'update'])
    ->name('products.update')
    /*->can('update', 'product')*/;

Route::delete('/deleteProduct/{product}', [ProductController::class, 'destroy'])
    ->name('products.delete')
    /*->can('delete', 'product')*/;

#PAYMENTS
Route::get('/payments', [PaymentController::class, 'index'])
    ->name('payments.index')
    /*->can('viewAny', Payment::class)*/;

Route::get('/payments/create', [PaymentController::class, 'create'])
    ->name('payments.create')
    /*->can('create', Payment::class)*/;

Route::post('/payments', [PaymentController::class, 'store'])
    ->name('payments.store')
    /*->can('create', Payment::class)*/;

Route::get("/payments/{payment}", [PaymentController::class, 'show'])
    ->name('payments.show')
    /*->can('view', 'payment')*/;

Route::get('/editPayment/{payment}', [PaymentController::class, 'edit'])
    ->name('payments.edit')
    /*->can('update', 'payment')*/;

Route::put('/updatePayment/{payment}', [PaymentController::class, 'update'])
    ->name('payments.update')
    /*->can('update', 'payment')*/;

Route::delete('/deletePayment/{payment}', [PaymentController::class, 'destroy'])
    ->name('payments.delete')
    /*->can('delete', 'payment')*/;

Route::post('/payments/pay/{order}', [StripeController::class, 'createCheckout'])
    ->name('payments.pay');

#ORDERS
Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders.index')
    /*->can('viewAny', Order::class)*/;

Route::get('/orders/create', [OrderController::class, 'create'])
    ->name('orders.create')
    /*->can('create', Order::class)*/;

Route::post('/orders', [OrderController::class, 'store'])
    ->name('orders.store')
    /*->can('create', Order::class)*/;

Route::get("/orders/{order}", [OrderController::class, 'show'])
    ->name('orders.show')
    /*->can('view', 'order')*/;

Route::get('/editOrder/{order}', [OrderController::class, 'edit'])
    ->name('orders.edit')
    /*->can('update', 'order')*/;

Route::put('/updateOrder/{order}', [OrderController::class, 'update'])
    ->name('orders.update')
    /*->can('update', 'order')*/;

Route::delete('/deleteOrder/{order}', [OrderController::class, 'destroy'])
    ->name('orders.delete')
    /*->can('delete', 'order')*/;

#ORDER ITEMS
Route::get('/orderitems', [OrderItemController::class, 'index'])
    ->name('orderitems.index')
    /*->can('viewAny', OrderItem::class)*/;

Route::get('/orderitems/create', [OrderItemController::class, 'create'])
    ->name('orderitems.create')
    /*->can('create', OrderItem::class)*/;

Route::post('/orderitems', [OrderItemController::class, 'store'])
    ->name('orderitems.store')
    /*->can('create', OrderItem::class)*/;

Route::get("/orderitems/{orderitem}", [OrderItemController::class, 'show'])
    ->name('orderitems.show')
    /*->can('view', 'orderitem')*/;

Route::get('/editOrderitem/{orderitem}', [OrderItemController::class, 'edit'])
    ->name('orderitems.edit')
    /*->can('update', 'orderitem')*/;

Route::put('/updateOrderitem/{orderitem}', [OrderItemController::class, 'update'])
    ->name('orderitems.update')
    /*->can('update', 'orderitem')*/;

Route::delete('/deleteOrderitem/{orderitem}', [OrderItemController::class, 'destroy'])
    ->name('orderitems.delete')
    /*->can('delete', 'orderitem')*/;

Route::get('/carrito', [OrderController::class, 'carrito'])
    ->name('orders.carrito');

//borrar cuando se implemente el login
use App\Services\UsersService;
Route::get('/forzar-login-admin', function () {
    $service = new UsersService();
    $user = $service->get(1); 
    Auth::login($user);
    return "Ya estás logueado como Admin";
});

Route::get('/forzar-login-user', function () {
    $service = new UsersService();
    $user = $service->get(2); 
    Auth::login($user);
    return "Ya estás logueado como User";
});

//ControlPanel

Route::get('/controlPanel', [ControlPanelController::class, 'index'])
    ->name('controlPanel.dashboard');