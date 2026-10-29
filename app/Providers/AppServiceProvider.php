<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer(
            ['layouts.landing', 'partials.landing.*', 'home'],
            function ($view) {
                $view->with([
                    'appName'      => config('app.name'),
                    'contactEmail' => config('mail.from.address'),
                    'loginUrl'     => Route::has('login') ? route('login') : url('/login'),
                    'registerUrl'  => Route::has('register') ? route('register') : url('/register'),
                    'termsUrl'     => url('/terms'),
                    'privacyUrl'   => url('/privacy'),
                ]);
            }
        );
    }
}