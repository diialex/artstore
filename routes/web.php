<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\StripeController;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Order;
use App\Services\UsersService;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin autenticación)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
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

Route::get('/users/{username}', [UsersController::class, 'show'])
    ->name('users.show')
    ->middleware('auth');

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
    ->middleware(['auth']);

Route::put('/updateAddress/{address}', [AddressController::class, 'update'])
    ->name('addresses.update')
    ->middleware(['auth'])->can('update', 'address');

Route::delete('/deleteAddress/{address}', [AddressController::class, 'delete'])
    ->name('addresses.delete')
    ->middleware(['auth']);

Route::post('/addProduct/{product}', [OrderController::class, 'addProducttoOrder'])
    ->name('orders.addProduct')
    ->can('create', Order::class);

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

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index')
    ->middleware(['auth'])->can('viewAny', Product::class);

Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create')
    ->middleware(['auth'])->can('admin-access');

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store')
    ->middleware(['auth'])->can('admin-access');

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

Route::post('/payments/pay/{order}', [StripeController::class, 'createCheckout'])
    ->name('payments.pay')
    ->middleware(['auth'])->can('create', Order::class);

#ORDERS

Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders.index')
    ->middleware(['auth']);

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
    ->middleware(['auth'])->can('delete', 'orderitem');

Route::get('/carrito', [OrderController::class, 'carrito'])
    ->name('orders.carrito')
    ->can('viewCarrito', Order::class);

Route::get('/favoritos', [UsersController::class, 'showFavorites'])
    ->name('users.favorites')
    ->middleware(['auth']);

Route::post('/favoritos/add', [UsersController::class, 'addFavorites'])
    ->name('users.favorites.add')
    ->middleware(['auth']);

Route::delete('/favoritos/{product}', [UsersController::class, 'removeFavorites'])
    ->name('users.favorites.remove')
    ->middleware(['auth']);

Route::post('/cart/increase/{item}', [OrderController::class, 'increaseItem'])
    ->name('cart.increase')
    ->can('create', Order::class);

Route::post('/cart/decrease/{item}', [OrderController::class, 'decreaseItem'])
    ->name('cart.decrease')
    ->can('create', Order::class);

Route::post('/cart/guest/increase', [OrderController::class, 'guestIncreaseItem'])
    ->name('cart.guest.increase');

Route::post('/cart/guest/decrease', [OrderController::class, 'guestDecreaseItem'])
    ->name('cart.guest.decrease');

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

Route::get('/controlPanel', [ControlPanelController::class, 'index'])
    ->name('controlPanel.dashboard')
    ->middleware(['auth'])->can('admin-access');

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'es'])) abort(400);
    
    if (auth()->check()) {
        $user = auth()->user();
        $user->locale = $locale;
        $user->save();
    } else {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


/*
|--------------------------------------------------------------------------
| RUTAS DE CLIENTE (Requieren Autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Redirección de Dashboard/Home autenticado
    Route::get('/home', function () { return view('auth.dashboard'); })->middleware('verified');

    // PERFIL Y FAVORITOS
    Route::controller(UsersController::class)->group(function () {
        Route::get('/perfil/{username}', 'show')->name('users.show');
        Route::get('/perfil/{username}/edit', 'edit')->name('users.edit');
        Route::put('/perfil/{id}', 'update')->name('users.update');
        
        Route::get('/favoritos', 'showFavorites')->name('users.favorites');
        Route::post('/favoritos/add', 'addFavorites')->name('users.favorites.add');
        Route::delete('/favoritos/{product}', 'removeFavorites')->name('users.favorites.remove');
        Route::get('/direcciones/usuario/{username}', 'showAddresses')->name('addresses.show');
    });

    // DIRECCIONES
    Route::controller(AddressController::class)->prefix('direcciones')->name('addresses.')->group(function () {
        Route::get('/crear', 'create')->can('create', Address::class)->name('create');
        Route::post('/', 'store')->can('create', Address::class)->name('store');
        Route::get('/{address}/editar', 'edit')->name('edit');
        Route::put('/{address}', 'update')->can('update', 'address')->name('update');
        Route::delete('/{address}', 'delete')->name('delete');
    });

    // CARRITO Y PEDIDOS (Flujo de compra)
    Route::controller(OrderController::class)->group(function () {
        Route::get('/carrito', 'carrito')->can('create', Order::class)->name('orders.carrito');
        Route::post('/carrito/add/{product}', 'addProducttoOrder')->can('create', Order::class)->name('orders.addProduct');
        Route::post('/carrito/increase/{item}', 'increaseItem')->can('create', Order::class)->name('cart.increase');
        Route::post('/carrito/decrease/{item}', 'decreaseItem')->can('create', Order::class)->name('cart.decrease');
        
        Route::get('/pedidos', 'index')->name('orders.index');
        Route::get('/pedidos/{order}', 'show')->name('orders.show');
    });
    // ELIMINAR ÍTEMS DEL CARRITO 
    Route::delete('/carrito/remove/{orderitem}', [OrderItemController::class, 'destroy'])->name('orderitems.delete');

    // PAGOS (Stripe)
    Route::controller(StripeController::class)->group(function () {
        Route::post('/payments/pay/{order}', 'createCheckout')->can('create', Order::class)->name('payments.pay');
        Route::get('/paymentSuccess', 'successPayment')->name('payments.success');
        Route::get('/paymentError', 'cancelPayment')->name('payments.cancel');
    });

    // CATÁLOGO PÚBLICO AUTENTICADO
    Route::controller(ProductController::class)->group(function () {
        Route::get('/productos', 'index')->name('products.index');
        Route::get('/productos/{product}', 'show')->name('products.show');
        Route::get('/categorias/{category}/productos', 'indexByCategory')->name('categories.products');
    });

});


/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRACIÓN (Requieren Autenticación + Rol Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:admin-access'])->prefix('admin')->group(function () {

    // PANEL DE CONTROL
    Route::get('/dashboard', [ControlPanelController::class, 'index'])->name('controlPanel.dashboard');

    // GESTIÓN DE USUARIOS
    Route::controller(UsersController::class)->name('users.')->group(function () {
        Route::get('/usuarios', 'index')->can('viewAny', User::class)->name('index');
        Route::get('/usuarios/crear', 'create')->can('create', User::class)->name('create');
        Route::post('/usuarios', 'store')->can('create', User::class)->name('store');
        Route::delete('/usuarios/{id}', 'delete')->name('delete');
    });

    // GESTIÓN DE ROLES
    Route::controller(RolesController::class)->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/crear', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{role}', 'show')->name('show');
        Route::get('/{role}/editar', 'edit')->name('edit');
        Route::put('/{role}', 'update')->name('update');
        Route::delete('/{role}', 'destroy')->name('delete'); // Mantenemos el nombre 'delete' para no romper vistas
    });

    // GESTIÓN DE CATEGORÍAS
    Route::controller(CategoryController::class)->prefix('categorias')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/crear', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}', 'show')->name('show');
        Route::get('/{category}/editar', 'edit')->name('edit');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'destroy')->name('delete');
    });

    // GESTIÓN DE PRODUCTOS (solo operaciones de modificación)
    Route::controller(ProductController::class)->prefix('productos')->name('products.')->group(function () {
        Route::get('/crear', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{product}/editar', 'edit')->name('edit');
        Route::put('/{product}', 'update')->name('update');
        Route::delete('/{product}', 'destroy')->name('delete');
    });

    // GESTIÓN DE PEDIDOS (Operaciones Admin)
    Route::controller(OrderController::class)->prefix('pedidos')->name('orders.')->group(function () {
        Route::get('/crear', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{order}/editar', 'edit')->name('edit');
        Route::put('/{order}', 'update')->name('update');
        Route::delete('/{order}', 'destroy')->name('delete');
    });

});


/*
|--------------------------------------------------------------------------
| HERRAMIENTAS DE DESARROLLO (solo funcionan en entorno local)
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    Route::get('/forzar-login-admin', function () {
        $service = new UsersService();
        Auth::login($service->get(1));
        return "Ya estás logueado como Admin. Ve a /admin/dashboard";
    });

    Route::get('/forzar-login-user', function () {
        $service = new UsersService();
        Auth::login($service->get(2));
        return "Ya estás logueado como User. Ve a la home";
    });
}