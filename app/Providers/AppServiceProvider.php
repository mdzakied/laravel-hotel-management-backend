<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Memetakan rute API secara manual
        Route::prefix('api') // Menambahkan prefix 'api' untuk rute
            ->middleware('api') // Menambahkan middleware api
            ->namespace($this->app->getNamespace())
            ->group(base_path('routes/api.php')); // Memuat rute dari file api.php
    }
}
