<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Acceso al catálogo (config/catalog.php).
 *
 * Punto único para leer categorías, productos y servicios. Cuando el
 * contenido pase a base de datos, solo cambia esta clase.
 */
class Catalog
{
    public function categories(): Collection
    {
        return collect(config('catalog.categories'))
            ->map(fn (array $category, string $slug) => ['slug' => $slug, ...$category]);
    }

    public function category(string $slug): ?array
    {
        return $this->categories()->get($slug);
    }

    public function defaultCategory(): array
    {
        return $this->categories()->first();
    }

    public function products(?string $category = null, ?string $type = null): Collection
    {
        return collect(config('catalog.products'))
            ->when($category, fn (Collection $items) => $items->where('category', $category))
            ->when($type, fn (Collection $items) => $items->where('type', $type))
            ->map(fn (array $product) => $this->hydrate($product))
            ->values();
    }

    /**
     * Un producto por su slug, dentro de una categoría.
     */
    public function product(string $category, string $slug): ?array
    {
        $product = collect(config('catalog.products'))
            ->first(fn (array $item) => $item['slug'] === $slug && $item['category'] === $category);

        return $product ? $this->hydrate($product) : null;
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
     * Completa un producto con valores por defecto y datos derivados.
     */
    protected function hydrate(array $product): array
    {
        $category = $this->category($product['category']);

        return [
            'tagline' => null,
            'description' => null,
            'gallery' => [],
            'specs' => [],
            'highlights' => [],
            'features' => [],
            'spec_groups' => [],
            'brochure' => null,
            ...$product,
            'category_name' => $category['name'] ?? $product['category'],
            'type_label' => Arr::get($category, "types.{$product['type']}", $product['type']),
            'url' => route('products.show', [$product['category'], $product['slug']]),
        ];
    }

    /**
     * Opciones para el select "¿Qué equipo necesitas?" del formulario.
     */
    public function equipmentOptions(): array
    {
        return collect(config('catalog.products'))
            ->pluck('name')
            ->unique()
            ->values()
            ->push('Otro / Aún no lo sé')
            ->all();
    }

    public function services(): Collection
    {
        return collect(config('catalog.services'))
            ->map(fn (array $service, string $slug) => ['slug' => $slug, ...$service]);
    }
}
