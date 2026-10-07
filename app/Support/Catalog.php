<?php

namespace App\Support;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteImage;
use Illuminate\Support\Collection;

/**
 * Acceso al catálogo para el sitio público.
 *
 * Lee de la base de datos (lo que se captura en /admin) y entrega arreglos
 * simples a las vistas, así las plantillas no dependen de los modelos.
 */
class Catalog
{
    /** @var Collection<string, array>|null */
    protected ?Collection $categories = null;

    public function categories(): Collection
    {
        return $this->categories ??= Category::query()
            ->ordered()
            ->with('types')
            ->get()
            ->mapWithKeys(fn (Category $category) => [$category->slug => $this->categoryData($category)]);
    }

    public function category(string $slug): ?array
    {
        return $this->categories()->get($slug);
    }

    public function defaultCategory(): ?array
    {
        return $this->categories()->first();
    }

    public function products(?string $category = null, ?string $type = null): Collection
    {
        return Product::query()
            ->published()
            ->ordered()
            ->with(['category', 'type', 'images'])
            ->when($category, fn ($query) => $query->whereRelation('category', 'slug', $category))
            ->when($type, fn ($query) => $query->whereRelation('type', 'slug', $type))
            ->get()
            ->map(fn (Product $product) => $this->productData($product));
    }

    /**
     * Un producto publicado por su slug, dentro de una categoría.
     */
    public function product(string $category, string $slug): ?array
    {
        $product = Product::query()
            ->published()
            ->with(['category', 'type', 'images'])
            ->where('slug', $slug)
            ->whereRelation('category', 'slug', $category)
            ->first();

        return $product ? $this->productData($product) : null;
    }

    /**
     * Productos de la misma categoría (primero los del mismo tipo), sin el actual.
     */
    public function related(array $product, int $limit = 3): Collection
    {
        return $this->products($product['category'])
            ->reject(fn (array $item) => $item['slug'] === $product['slug'])
            ->sortByDesc(fn (array $item) => $item['type'] === $product['type'])
            ->take($limit)
            ->values();
    }

    /**
     * Opciones para el select "¿Qué equipo necesitas?" del formulario.
     */
    public function equipmentOptions(): array
    {
        return Product::query()
            ->published()
            ->ordered()
            ->pluck('name')
            ->unique()
            ->values()
            ->push('Otro / Aún no lo sé')
            ->all();
    }

    public function brands(): array
    {
        return Brand::query()
            ->active()
            ->ordered()
            ->get()
            ->map(fn (Brand $brand) => ['name' => $brand->name, 'logo' => $brand->logo])
            ->all();
    }

    public function services(): Collection
    {
        return collect(config('catalog.services'))
            ->map(fn (array $service, string $slug) => [
                'slug' => $slug,
                ...$service,
                'image' => SiteImage::path("services.{$slug}", $service['image'] ?? null),
            ]);
    }

    protected function categoryData(Category $category): array
    {
        return [
            'slug' => $category->slug,
            'name' => $category->name,
            'label' => $category->label,
            'card_title' => $category->card_title,
            'summary' => $category->summary,
            'excerpt' => $category->excerpt,
            'description' => $category->description,
            'image' => $category->image,
            'benefits' => $category->benefits ?? [],
            'types' => $category->types->pluck('name', 'slug')->all(),
        ];
    }

    protected function productData(Product $product): array
    {
        $gallery = $product->images->pluck('path')->all();

        return [
            'slug' => $product->slug,
            'name' => $product->name,
            'brand' => $product->brand,
            'category' => $product->category->slug,
            'category_name' => $product->category->name,
            'type' => $product->type?->slug,
            'type_label' => $product->type?->name ?? $product->category->name,
            'tagline' => $product->tagline,
            'description' => $product->description,
            'image' => $gallery[0] ?? null,
            'gallery' => $gallery,
            'specs' => $this->pairs($product->card_specs),
            'highlights' => $this->pairs($product->highlights),
            'features' => array_values(array_filter($product->features ?? [], fn ($item) => filled($item['title'] ?? null))),
            'spec_groups' => collect($product->spec_groups ?? [])
                ->filter(fn ($group) => filled($group['title'] ?? null))
                ->mapWithKeys(fn ($group) => [$group['title'] => $this->pairs($group['rows'] ?? [])])
                ->all(),
            'brochure' => $product->brochure,
            'url' => route('products.show', [$product->category->slug, $product->slug]),
        ];
    }

    /**
     * [['label' => 'Peso', 'value' => '21 t']] → ['Peso' => '21 t']
     */
    protected function pairs(?array $rows): array
    {
        return collect($rows ?? [])
            ->filter(fn ($row) => filled($row['label'] ?? null))
            ->mapWithKeys(fn ($row) => [$row['label'] => $row['value'] ?? ''])
            ->all();
    }
}
