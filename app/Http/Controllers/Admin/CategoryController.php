<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::ordered()->withCount('products')->with('types')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', ['category' => new Category]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($this->attributes($request));
        $this->syncImage($request, $category);
        $this->syncTypes($request, $category);

        return redirect()->route('admin.categories.edit', $category)->with('status', 'Categoría creada.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', ['category' => $category->load('types')]);
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($this->attributes($request, $category));
        $this->syncImage($request, $category);
        $this->syncTypes($request, $category);

        return redirect()->route('admin.categories.edit', $category)->with('status', 'Cambios guardados.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'No se puede eliminar: la categoría todavía tiene productos. Muévelos o elimínalos primero.');
        }

        Uploads::delete($category->image);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', "Se eliminó «{$category->name}».");
    }

    protected function attributes(CategoryRequest $request, ?Category $category = null): array
    {
        $data = $request->validated();

        return [
            'name' => $data['name'],
            'slug' => $this->uniqueSlug($data['slug'] ?? null ?: $data['name'], $category),
            'label' => $data['label'] ?? null,
            'card_title' => $data['card_title'] ?? null,
            'summary' => $data['summary'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'benefits' => collect($data['benefits'] ?? [])->pluck('text')->filter()->values()->all(),
        ];
    }

    protected function syncImage(CategoryRequest $request, Category $category): void
    {
        if ($request->boolean('remove_image') || $request->hasFile('image')) {
            Uploads::delete($category->image);
            $category->update(['image' => null]);
        }

        if ($request->hasFile('image')) {
            $category->update(['image' => Uploads::store($request->file('image'), 'categories')]);
        }
    }

    /**
     * Crea, actualiza, reordena y elimina los tipos de la categoría.
     */
    protected function syncTypes(CategoryRequest $request, Category $category): void
    {
        $keep = [];

        foreach (array_values($request->input('types', [])) as $order => $item) {
            $name = trim($item['name'] ?? '');

            if ($name === '') {
                continue;
            }

            $type = ! empty($item['id']) ? $category->types()->find($item['id']) : null;
            $slug = $type?->slug ?? $this->uniqueTypeSlug($category, $name);

            $type = $category->types()->updateOrCreate(
                ['id' => $type?->id],
                ['name' => $name, 'slug' => $slug, 'sort_order' => $order],
            );

            $keep[] = $type->id;
        }

        // Los productos de un tipo eliminado quedan "sin tipo"
        $category->types()->whereNotIn('id', $keep)->delete();
    }

    protected function uniqueSlug(string $value, ?Category $category): string
    {
        $base = Str::slug($value) ?: 'categoria';
        $slug = $base;
        $i = 2;

        while (Category::where('slug', $slug)->when($category, fn ($q) => $q->whereKeyNot($category->id))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    protected function uniqueTypeSlug(Category $category, string $name): string
    {
        $base = Str::slug($name) ?: 'tipo';
        $slug = $base;
        $i = 2;

        while ($category->types()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
