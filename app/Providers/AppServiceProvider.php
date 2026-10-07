<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
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
        // Paginación con el marcado de Bootstrap (panel administrativo)
        Paginator::useBootstrapFive();

        // URLs del panel en español: /admin/productos/nuevo, /admin/productos/5/editar
        Route::resourceVerbs(['create' => 'nuevo', 'edit' => 'editar']);
    }
}
