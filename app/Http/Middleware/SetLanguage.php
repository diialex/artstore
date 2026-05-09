<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLanguage
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->locale) {
            App::setLocale(auth()->user()->locale);
        } 
        elseif (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } 
        else {
            App::setLocale(config('app.fallback_locale', 'es'));
        }

        return $next($request);
    }
}