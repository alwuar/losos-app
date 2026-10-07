<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Panel administrativo (/admin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->middleware('throttle:6,1')->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('productos', ProductController::class)
            ->except('show')
            ->parameters(['productos' => 'product'])
            ->names('products');

        Route::resource('categorias', CategoryController::class)
            ->except('show')
            ->parameters(['categorias' => 'category'])
            ->names('categories');

        Route::resource('marcas', BrandController::class)
            ->except('show')
            ->parameters(['marcas' => 'brand'])
            ->names('brands');

        Route::get('imagenes', [SiteImageController::class, 'index'])->name('site-images.index');
        Route::put('imagenes/{siteImage}', [SiteImageController::class, 'update'])->name('site-images.update');
        Route::delete('imagenes/{siteImage}', [SiteImageController::class, 'destroy'])->name('site-images.destroy');
    });
});
