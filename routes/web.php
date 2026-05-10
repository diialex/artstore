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
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

#VISTAS PÚBLICAS
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paymentSuccess', [StripeController::class, 'successPayment'])->name('payments.success');
Route::get('/paymentError', [StripeController::class, 'cancelPayment'])->name('payments.cancel');

Route::get('home', function () {
    return view('auth.dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('login', function () {
    return redirect()->intended('/')->with('openLogin', 'true');
})->name('login');


#USER CRUD — solo admin puede gestionar usuarios desde el panel

Route::get('/users', [UsersController::class, 'index'])
    ->name('users.index')
    ->middleware(['auth'])->can('viewAny', User::class);

Route::get('/users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware(['auth'])->can('create', User::class);

Route::post('/users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware(['auth'])->can('create', User::class);

Route::get("/users/{username}", [UsersController::class, 'show'])
    ->name('users.show')
    ->middleware(['auth']);

Route::get('/users/{username}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware(['auth']);

Route::put('/users/{id}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware(['auth']);

Route::delete('/users/{id}', [UsersController::class, 'delete'])
    ->name('users.delete')
    ->middleware(['auth'])->can('admin-access');

#ROLE — solo admin

Route::get('/roles', [RolesController::class, 'index'])
    ->name('roles.index')
    ->middleware(['auth'])->can('admin-access');

Route::get('/roles/create', [RolesController::class, 'create'])
    ->name('roles.create')
    ->middleware(['auth'])->can('admin-access');

Route::post('/roles', [RolesController::class, 'store'])
    ->name('roles.store')
    ->middleware(['auth'])->can('admin-access');

Route::get("/roles/{role}", [RolesController::class, 'show'])
    ->name('roles.show')
    ->middleware(['auth'])->can('admin-access');

Route::get("/roles/{role}/edit", [RolesController::class, 'edit'])
    ->name('roles.edit')
    ->middleware(['auth'])->can('admin-access');

Route::put('/roles/{role}', [RolesController::class, 'update'])
    ->name('roles.update')
    ->middleware(['auth'])->can('admin-access');

Route::delete('/roles/{role}', [RolesController::class, 'destroy'])
    ->name('roles.delete')
    ->middleware(['auth'])->can('admin-access');

#ADDRESS

Route::get('/addresses', [AddressController::class, 'index'])
    ->name('addresses.index')
    ->middleware(['auth'])->can('admin-access');

Route::get('/addresses/create', [AddressController::class, 'create'])
    ->name('addresses.create')
    ->middleware(['auth'])->can('create', Address::class);

Route::post('/addresses', [AddressController::class, 'store'])
    ->name('addresses.store')
    ->middleware(['auth'])->can('create', Address::class);

Route::get("/addresses/user/{username}", [UsersController::class, 'showAddresses'])
    ->name('addresses.show')
    ->middleware(['auth']);

Route::get('/editAddress/{address}', [AddressController::class, 'edit'])
    ->name('addresses.edit')
    ->middleware(['auth'])->can('update', 'address');

Route::put('/updateAddress/{address}', [AddressController::class, 'update'])
    ->name('addresses.update')
    ->middleware(['auth'])->can('update', 'address');

Route::delete('/deleteAddress/{address}', [AddressController::class, 'delete'])
    ->name('addresses.delete')
    ->middleware(['auth'])->can('delete', 'address');

Route::post('/addProduct/{product}', [OrderController::class, 'addProducttoOrder'])
    ->name('orders.addProduct')
    ->middleware(['auth'])->can('create', Order::class);

#CATEGORIES

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index')
    ->middleware(['auth'])->can('admin-access');

Route::get('/categories/create', [CategoryController::class, 'create'])
    ->name('categories.create')
    ->middleware(['auth'])->can('admin-access');

Route::post('/categories', [CategoryController::class, 'store'])
    ->name('categories.store')
    ->middleware(['auth'])->can('admin-access');

Route::get("/categories/{category}", [CategoryController::class, 'show'])
    ->name('categories.show')
    ->middleware(['auth'])->can('admin-access');

Route::get('/editCategory/{category}', [CategoryController::class, 'edit'])
    ->name('categories.edit')
    ->middleware(['auth'])->can('admin-access');

Route::put('/updateCategory/{category}', [CategoryController::class, 'update'])
    ->name('categories.update')
    ->middleware(['auth'])->can('admin-access');

Route::delete('/deleteCategory/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.delete')
    ->middleware(['auth'])->can('admin-access');

// Filtrado de productos por categoría — cualquier usuario autenticado
Route::get('/categories/{category}/products', [ProductController::class, 'indexByCategory'])
    ->name('categories.products')
    ->middleware(['auth'])->can('viewAny', Product::class);

#PRODUCTS

// Catálogo/home — cualquier usuario autenticado
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index')
    ->middleware(['auth'])->can('viewAny', Product::class);

Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create')
    ->middleware(['auth'])->can('admin-access');

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store')
    ->middleware(['auth'])->can('admin-access');

// Ver producto — cualquier usuario
Route::get("/products/{product}", [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/editProduct/{product}', [ProductController::class, 'edit'])
    ->name('products.edit')
    ->middleware(['auth'])->can('admin-access');

Route::put('/updateProduct/{product}', [ProductController::class, 'update'])
    ->name('products.update')
    ->middleware(['auth'])->can('admin-access');

Route::delete('/deleteProduct/{product}', [ProductController::class, 'destroy'])
    ->name('products.delete')
    ->middleware(['auth'])->can('admin-access');

#PAYMENTS

Route::get('/payments', [PaymentController::class, 'index'])
    ->name('payments.index')
    ->middleware(['auth'])->can('admin-access');

Route::get('/payments/create', [PaymentController::class, 'create'])
    ->name('payments.create')
    ->middleware(['auth'])->can('admin-access');

Route::post('/payments', [PaymentController::class, 'store'])
    ->name('payments.store')
    ->middleware(['auth'])->can('admin-access');

Route::get("/payments/{payment}", [PaymentController::class, 'show'])
    ->name('payments.show')
    ->middleware(['auth'])->can('admin-access');

Route::get('/editPayment/{payment}', [PaymentController::class, 'edit'])
    ->name('payments.edit')
    ->middleware(['auth'])->can('admin-access');

Route::put('/updatePayment/{payment}', [PaymentController::class, 'update'])
    ->name('payments.update')
    ->middleware(['auth'])->can('admin-access');

Route::delete('/deletePayment/{payment}', [PaymentController::class, 'destroy'])
    ->name('payments.delete')
    ->middleware(['auth'])->can('admin-access');

// Checkout — usuario autenticado
Route::post('/payments/pay/{order}', [StripeController::class, 'createCheckout'])
    ->name('payments.pay')
    ->middleware(['auth'])->can('create', Order::class);

#ORDERS

Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders.index')
    ->middleware(['auth'])->can('admin-access');

Route::get('/orders/create', [OrderController::class, 'create'])
    ->name('orders.create')
    ->middleware(['auth'])->can('admin-access');

Route::post('/orders', [OrderController::class, 'store'])
    ->name('orders.store')
    ->middleware(['auth'])->can('admin-access');

Route::get("/orders/{order}", [OrderController::class, 'show'])
    ->name('orders.show')
    ->middleware(['auth']);

Route::get('/editOrder/{order}', [OrderController::class, 'edit'])
    ->name('orders.edit')
    ->middleware(['auth'])->can('admin-access');

Route::put('/updateOrder/{order}', [OrderController::class, 'update'])
    ->name('orders.update')
    ->middleware(['auth'])->can('admin-access');

Route::delete('/deleteOrder/{order}', [OrderController::class, 'destroy'])
    ->name('orders.delete')
    ->middleware(['auth'])->can('admin-access');

#ORDER ITEMS

Route::get('/orderitems', [OrderItemController::class, 'index'])
    ->name('orderitems.index')
    ->middleware(['auth'])->can('admin-access');

Route::get('/orderitems/create', [OrderItemController::class, 'create'])
    ->name('orderitems.create')
    ->middleware(['auth'])->can('admin-access');

Route::post('/orderitems', [OrderItemController::class, 'store'])
    ->name('orderitems.store')
    ->middleware(['auth'])->can('admin-access');

Route::get("/orderitems/{orderitem}", [OrderItemController::class, 'show'])
    ->name('orderitems.show')
    ->middleware(['auth'])->can('admin-access');

Route::get('/editOrderitem/{orderitem}', [OrderItemController::class, 'edit'])
    ->name('orderitems.edit')
    ->middleware(['auth'])->can('admin-access');

Route::put('/updateOrderitem/{orderitem}', [OrderItemController::class, 'update'])
    ->name('orderitems.update')
    ->middleware(['auth'])->can('admin-access');

Route::delete('/deleteOrderitem/{orderitem}', [OrderItemController::class, 'destroy'])
    ->name('orderitems.delete')
    ->middleware(['auth'])->can('admin-access');

// Carrito — usuario autenticado
Route::get('/carrito', [OrderController::class, 'carrito'])
    ->name('orders.carrito')
    ->middleware(['auth'])->can('create', Order::class);

// Favoritos — usuario autenticado
Route::get('/favoritos', [UsersController::class, 'showFavorites'])
    ->name('users.favorites')
    ->middleware(['auth']);

Route::post('/favoritos/add', [UsersController::class, 'addFavorites'])
    ->name('users.favorites.add')
    ->middleware(['auth']);

Route::delete('/favoritos/{product}', [UsersController::class, 'removeFavorites'])
    ->name('users.favorites.remove')
    ->middleware(['auth']);

// Carrito — aumentar / disminuir cantidad
Route::post('/cart/increase/{item}', [OrderController::class, 'increaseItem'])
    ->name('cart.increase')
    ->middleware(['auth'])->can('create', Order::class);

Route::post('/cart/decrease/{item}', [OrderController::class, 'decreaseItem'])
    ->name('cart.decrease')
    ->middleware(['auth'])->can('create', Order::class);

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

//ControlPanel — solo admin
Route::get('/controlPanel', [ControlPanelController::class, 'index'])
    ->name('controlPanel.dashboard')
    ->middleware(['auth'])->can('admin-access');

//Idiomas y traducciones
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    if (auth()->check()) {
        $user = auth()->user();
        $user->locale = $locale;
        $user->save();
    } else {
        session()->put('locale', $locale);
    }

    return redirect()->back();
})->name('lang.switch');