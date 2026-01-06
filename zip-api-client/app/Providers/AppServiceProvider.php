<?php

namespace App\Providers;

use App\Services\ApiAuthService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register ApiAuthService as singleton
        $this->app->singleton(ApiAuthService::class, function ($app) {
            return new ApiAuthService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share authentication status with all views
        view()->composer('*', function ($view) {
            $isAuthenticated = Session::has('api_token') && Session::has('user');
            $user = Session::get('user');

            $view->with([
                'auth' => (object)[
                    'check' => $isAuthenticated,
                    'user' => $user,
                ],
            ]);
        });
    }
}
