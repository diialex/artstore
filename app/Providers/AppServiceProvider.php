<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
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
        // Gate de conveniencia para comprobar rol admin
        Gate::define('admin-access', function (User $user) {
            return $user->hasRol('admin');
        });

        // Registro de policies
        Gate::policy(Product::class, ProductsPolicy::class);
        Gate::policy(Order::class, OrdersPolicy::class);
        Gate::policy(Address::class, AddressesPolicy::class);
        Gate::policy(User::class, UsersPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
    }
}
