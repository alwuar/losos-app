<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'Productos', 'value' => Product::count(), 'route' => 'admin.products.index', 'icon' => 'bi-truck'],
                ['label' => 'Publicados', 'value' => Product::published()->count(), 'route' => 'admin.products.index', 'icon' => 'bi-eye'],
                ['label' => 'Categorías', 'value' => Category::count(), 'route' => 'admin.categories.index', 'icon' => 'bi-grid'],
                ['label' => 'Marcas', 'value' => Brand::count(), 'route' => 'admin.brands.index', 'icon' => 'bi-award'],
            ],
            'latest' => Product::with(['category', 'images'])->latest('updated_at')->take(5)->get(),
        ]);
    }
}
