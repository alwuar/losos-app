<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request, Catalog $catalog, ?string $category = null): View
    {
        $current = $category
            ? $catalog->category($category) ?? abort(404)
            : $catalog->defaultCategory() ?? abort(404);

        $type = $request->query('tipo');

        if ($type !== null && ! array_key_exists($type, $current['types'])) {
            $type = null;
        }

        $type ??= array_key_first($current['types']);

        return view('pages.products.index', [
            'categories' => $catalog->categories(),
            'category' => $current,
            'type' => $type,
            'products' => $catalog->products($current['slug'], $type),
        ]);
    }

    public function show(Catalog $catalog, string $category, string $product): View
    {
        $item = $catalog->product($category, $product) ?? abort(404);

        return view('pages.products.show', [
            'product' => $item,
            'category' => $catalog->category($category),
            'related' => $catalog->related($item),
        ]);
    }
}
