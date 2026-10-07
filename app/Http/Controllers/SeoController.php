<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

/**
 * sitemap.xml generado con las URLs reales del sitio.
 */
class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $pages = collect([
            ['url' => route('home'), 'priority' => '1.0'],
            ['url' => route('about'), 'priority' => '0.6'],
            ['url' => route('services'), 'priority' => '0.7'],
            ['url' => route('contact'), 'priority' => '0.6'],
        ]);

        $categories = Category::query()->ordered()->get()->map(fn (Category $category) => [
            'url' => route('products.index', $category->slug),
            'lastmod' => $category->updated_at,
            'priority' => '0.8',
        ]);

        $products = Product::query()->published()->ordered()->with('category')->get()->map(fn (Product $product) => [
            'url' => route('products.show', [$product->category->slug, $product->slug]),
            'lastmod' => $product->updated_at,
            'priority' => '0.9',
        ]);

        $xml = view('seo.sitemap', ['urls' => $pages->concat($categories)->concat($products)])->render();

        return response('<?xml version="1.0" encoding="UTF-8"?>'."\n".$xml)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
