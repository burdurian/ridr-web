<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\IyzicoService;
use App\Services\SubscriptionService;
use App\Services\SupabaseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SupabaseService::class, function ($app) {
            return new SupabaseService();
        });

        $this->app->singleton(IyzicoService::class, function ($app) {
            return new IyzicoService();
        });
        
        $this->app->singleton(SubscriptionService::class, function ($app) {
            return new SubscriptionService(
                $app->make(IyzicoService::class),
                $app->make(SupabaseService::class)
            );
        });
        
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(SupabaseService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
