<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['category', 'type', 'images'])
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('categoria'), fn ($query) => $query->where('category_id', $request->integer('categoria')))
            ->orderBy('category_id')
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product(['is_published' => true, 'card_specs' => $this->defaultCardSpecs()]),
            'categories' => Category::ordered()->with('types')->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = Product::create($this->attributes($request));
        $this->syncFiles($request, $product);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Producto creado.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product->load('images'),
            'categories' => Category::ordered()->with('types')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($this->attributes($request, $product));
        $this->syncFiles($request, $product);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Cambios guardados.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            Uploads::delete($image->path);
        }

        Uploads::delete($product->brochure);
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', "Se eliminó «{$product->name}».");
    }

    /**
     * Datos del formulario listos para guardar (filas vacías fuera).
     */
    protected function attributes(ProductRequest $request, ?Product $product = null): array
    {
        $data = $request->validated();

        return [
            'name' => $data['name'],
            'slug' => $this->uniqueSlug($data['slug'] ?? null ?: $data['name'], $product),
            'category_id' => $data['category_id'],
            'product_type_id' => $data['product_type_id'] ?? null,
            'brand' => $data['brand'] ?? null,
            'tagline' => $data['tagline'] ?? null,
            'description' => $data['description'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $data['sort_order'] ?? 0,
            'card_specs' => $this->cleanPairs($data['card_specs'] ?? []),
            'highlights' => $this->cleanPairs($data['highlights'] ?? []),
            'features' => collect($data['features'] ?? [])
                ->filter(fn ($item) => filled($item['title'] ?? null))
                ->map(fn ($item) => ['title' => $item['title'], 'text' => $item['text'] ?? ''])
                ->values()
                ->all(),
            'spec_groups' => collect($data['spec_groups'] ?? [])
                ->filter(fn ($group) => filled($group['title'] ?? null))
                ->map(fn ($group) => ['title' => $group['title'], 'rows' => $this->cleanPairs($group['rows'] ?? [])])
                ->values()
                ->all(),
        ];
    }

    /**
     * Galería (nuevas, orden, textos, borrar) y ficha técnica en PDF.
     */
    protected function syncFiles(ProductRequest $request, Product $product): void
    {
        foreach ($request->input('gallery', []) as $id => $item) {
            $image = $product->images()->find($id);

            if (! $image) {
                continue;
            }

            if (! empty($item['remove'])) {
                Uploads::delete($image->path);
                $image->delete();

                continue;
            }

            $image->update([
                'alt' => $item['alt'] ?? null,
                'sort_order' => (int) ($item['sort_order'] ?? 0),
            ]);
        }

        $next = (int) $product->images()->max('sort_order') + 1;

        foreach ($request->file('images', []) as $file) {
            $product->images()->create([
                'path' => Uploads::store($file, 'products'),
                'alt' => $product->name,
                'sort_order' => $next++,
            ]);
        }

        if ($request->boolean('remove_brochure') || $request->hasFile('brochure')) {
            Uploads::delete($product->brochure);
            $product->update(['brochure' => null]);
        }

        if ($request->hasFile('brochure')) {
            $product->update(['brochure' => Uploads::store($request->file('brochure'), 'brochures')]);
        }
    }

    protected function cleanPairs(array $rows): array
    {
        return collect($rows)
            ->filter(fn ($row) => filled($row['label'] ?? null))
            ->map(fn ($row) => ['label' => trim($row['label']), 'value' => trim($row['value'] ?? '')])
            ->values()
            ->all();
    }

    protected function uniqueSlug(string $value, ?Product $product): string
    {
        $base = Str::slug($value) ?: 'producto';
        $slug = $base;
        $i = 2;

        while (Product::where('slug', $slug)->when($product, fn ($q) => $q->whereKeyNot($product->id))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    protected function defaultCardSpecs(): array
    {
        return [
            ['label' => 'Peso operativo', 'value' => ''],
            ['label' => 'Capacidad de bote', 'value' => ''],
            ['label' => 'Potencia nominal', 'value' => ''],
            ['label' => 'Motor', 'value' => ''],
        ];
    }
}
