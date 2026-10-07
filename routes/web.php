<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/quienes-somos', AboutController::class)->name('about');

Route::get('/productos/{category?}', [ProductController::class, 'index'])->name('products.index');

Route::get('/servicios', ServiceController::class)->name('services');

Route::get('/contacto', [ContactController::class, 'show'])->name('contact');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');
