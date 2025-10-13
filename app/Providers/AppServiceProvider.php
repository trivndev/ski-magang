<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        // Ensure the application uses Tailwind-styled pagination
        // and our customized Tailwind view (limited to 5 pages with active state).
        Paginator::useTailwind();

        // Point the paginator to the overridden Tailwind view under resources/views/vendor/pagination/tailwind.blade.php
        Paginator::defaultView('pagination::tailwind');
    }
}
