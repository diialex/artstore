<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Services\GuestCartService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
use App\Services\UsersService;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class, function ($app) {
            return new class($app) implements LoginResponse {
                public function __construct(private $app) {}
                public function toResponse($request) {
                    $user = auth()->user();
                    $this->app->make(GuestCartService::class)->mergeIntoUserOrder($user);

                    if ($user->hasRol('admin') && !$user->hasRol('user')) {
                        return redirect()->route('controlPanel.dashboard');
                    }

                    return redirect()->intended(route('home'));
                }
            };
        });

        $this->app->singleton(RegisterResponse::class, function ($app) {
            return new class($app) implements RegisterResponse {
                public function __construct(private $app) {}
                public function toResponse($request) {
                    $this->app->make(GuestCartService::class)->mergeIntoUserOrder(auth()->user());
                    return redirect()->route('home');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::authenticateUsing(function ($request) {
            try {
                $userService = new UsersService;
                $user = $userService->login($request);
                
                if ($user && $user->decryptPassword($request->password)) {
                    return $user;
                }
            } catch (\Throwable $e) {
                // Si ocurre cualquier error, retornar null para mostrar mensaje de error estándar
                return null;
            }
            
            return null; // Usuario no encontrado o contraseña incorrecta
        });
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip()
            );
        });

        Fortify::requestPasswordResetLinkView(function(){
            return view('auth.forgot-password');
        });

        Fortify::loginView(function () {
            return redirect()->route('login');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}
