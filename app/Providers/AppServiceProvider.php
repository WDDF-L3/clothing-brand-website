<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CartService::class);
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Use simple tailwind-friendly pagination
        Paginator::defaultView('vendor.pagination.simple-tailwind');
    }
}
