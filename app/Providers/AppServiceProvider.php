<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Services\GuestCartService;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Role;
use App\Policies\ProductsPolicy;
use App\Policies\CategoiesPolicy;
use App\Policies\OrdersPolicy;
use App\Policies\PaymentsPolicy;
use App\Policies\AddressesPolicy;
use App\Policies\UsersPolicy;
use App\Policies\OrderItemsPolicy;
use App\Policies\RolePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        // Comparte el nº de artículos del carrito con el navbar (badge global)
        View::composer('navBar', function ($view) {
            $cartItemCount = 0;

            if (Auth::guest()) {
                $cart = app(GuestCartService::class)->getCart();
                $cartItemCount = (int) collect($cart['items'] ?? [])->sum('quantity');
            } else {
                $order = Order::where('user_id', Auth::id())
                    ->whereIn('status', ['pending', 'failed'])
                    ->first();
                $cartItemCount = $order ? (int) $order->items()->sum('quantity') : 0;
            }

            $view->with('cartItemCount', $cartItemCount);
        });

        // Gate de conveniencia para comprobar rol admin
        Gate::define('admin-access', function (User $user) {
            return $user->hasRol('admin');
        });

        // Acceso a la tienda: guests y usuarios con rol 'user'; deniega admins puros
        Gate::define('store-access', function (?User $user) {
            if (!$user) return true;
            return $user->hasRol('user');
        });

        // Registro de policies
        Gate::policy(Product::class, ProductsPolicy::class);
        Gate::policy(Order::class, OrdersPolicy::class);
        Gate::policy(Address::class, AddressesPolicy::class);
        Gate::policy(User::class, UsersPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(OrderItem::class, OrderItemsPolicy::class);
    }
}
