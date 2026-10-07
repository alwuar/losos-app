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
            ->map(function (array $product) {
                $category = $this->category($product['category']);

                return [
                    ...$product,
                    'type_label' => Arr::get($category, "types.{$product['type']}", $product['type']),
                ];
            })
            ->values();
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
