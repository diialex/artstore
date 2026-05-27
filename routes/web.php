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