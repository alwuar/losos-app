<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteImage;
use Illuminate\Database\Seeder;

/**
 * Llena el catálogo con el contenido inicial de la maqueta
 * (database/seeders/data/catalog.php). Se puede correr varias veces:
 * solo crea lo que no existe.
 */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $data = require __DIR__.'/data/catalog.php';

        $this->seedCategories($data['categories']);
        $this->seedProducts($data['products']);
        $this->seedBrands($data['brands']);
        $this->seedSiteImages();
    }

    protected function seedCategories(array $categories): void
    {
        $order = 0;

        foreach ($categories as $slug => $item) {
            $category = Category::firstOrCreate(['slug' => $slug], [
                'name' => $item['name'],
                'label' => $item['label'] ?? null,
                'card_title' => $item['card_title'] ?? null,
                'summary' => $item['summary'] ?? null,
                'excerpt' => $item['excerpt'] ?? null,
                'description' => $item['description'] ?? null,
                'image' => $this->existing($item['image'] ?? null),
                'benefits' => $item['benefits'] ?? [],
                'sort_order' => $order++,
            ]);

            $typeOrder = 0;

            foreach ($item['types'] ?? [] as $typeSlug => $typeName) {
                $category->types()->firstOrCreate(['slug' => $typeSlug], [
                    'name' => $typeName,
                    'sort_order' => $typeOrder++,
                ]);
            }
        }
    }

    protected function seedProducts(array $products): void
    {
        foreach ($products as $order => $item) {
            if (Product::where('slug', $item['slug'])->exists()) {
                continue;
            }

            $category = Category::where('slug', $item['category'])->firstOrFail();
            $type = $category->types()->where('slug', $item['type'])->first();

            $product = Product::create([
                'category_id' => $category->id,
                'product_type_id' => $type?->id,
                'name' => $item['name'],
                'slug' => $item['slug'],
                'brand' => $item['brand'] ?? null,
                'tagline' => $item['tagline'] ?? null,
                'description' => $item['description'] ?? null,
                'card_specs' => $this->pairs($item['specs'] ?? []),
                'highlights' => $this->pairs($item['highlights'] ?? []),
                'features' => $item['features'] ?? [],
                'spec_groups' => collect($item['spec_groups'] ?? [])
                    ->map(fn (array $rows, string $title) => ['title' => $title, 'rows' => $this->pairs($rows)])
                    ->values()
                    ->all(),
                'brochure' => $this->existing($item['brochure'] ?? null),
                'is_published' => true,
                'sort_order' => $order,
            ]);

            foreach (array_values(array_filter($item['gallery'] ?? [], fn ($path) => $this->existing($path))) as $i => $path) {
                $product->images()->create(['path' => $path, 'alt' => $product->name, 'sort_order' => $i]);
            }
        }
    }

    protected function seedBrands(array $brands): void
    {
        foreach ($brands as $order => $item) {
            Brand::firstOrCreate(['name' => $item['name']], [
                'logo' => $this->existing($item['logo'] ?? null),
                'is_active' => true,
                'sort_order' => $order,
            ]);
        }
    }

    protected function seedSiteImages(): void
    {
        $order = 0;

        foreach (config('losos.site_images') as $key => $item) {
            SiteImage::firstOrCreate(['key' => $key], [
                'label' => $item['label'],
                'help' => $item['help'] ?? null,
                'path' => null, // null = usar la imagen por defecto de config/losos.php
                'sort_order' => $order++,
            ]);
        }
    }

    /**
     * ['Peso' => '21 t'] → [['label' => 'Peso', 'value' => '21 t']]
     */
    protected function pairs(array $map): array
    {
        return collect($map)
            ->map(fn ($value, $label) => ['label' => (string) $label, 'value' => (string) $value])
            ->values()
            ->all();
    }

    /**
     * Devuelve la ruta solo si el archivo existe en public/.
     */
    protected function existing(?string $path): ?string
    {
        return $path && file_exists(public_path($path)) ? $path : null;
    }
}
