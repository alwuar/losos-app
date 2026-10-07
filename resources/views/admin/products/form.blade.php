@php
    $editing = $product->exists;
    $features = old('features', $product->features ?? []);
    $groups = old('spec_groups', $product->spec_groups ?? []);
@endphp

<x-layouts.admin :title="$editing ? $product->name : 'Nuevo producto'">
    <x-admin.page-header :title="$editing ? $product->name : 'Nuevo producto'" :back="route('admin.products.index')">
        @if ($editing && $product->is_published)
            <x-slot:actions>
                <x-ui.button :href="route('products.show', [$product->category->slug, $product->slug])" variant="outline-secondary" target="_blank" rel="noopener">
                    <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> Ver en el sitio
                </x-ui.button>
            </x-slot:actions>
        @endif
    </x-admin.page-header>

    <form method="POST" enctype="multipart/form-data" class="admin-form"
          action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-xl-8">
                <x-admin.card title="Datos generales">
                    <div class="row g-3">
                        <x-forms.input class="col-md-7" name="name" label="Nombre del equipo" :value="$product->name" placeholder="ZE215E PRO" required />
                        <x-forms.input class="col-md-5" name="brand" label="Marca" :value="$product->brand" placeholder="Zoomlion" />
                        <x-forms.input class="col-12" name="tagline" label="Frase corta" :value="$product->tagline" placeholder="Potencia clásica, desempeño evolucionado." />
                        <x-admin.textarea class="col-12" name="description" label="Descripción" :value="$product->description" rows="4" />
                        <x-forms.input class="col-12" name="slug" label="URL (opcional)" :value="$product->slug" placeholder="se genera con el nombre"
                            help="Solo letras, números y guiones." />
                    </div>
                </x-admin.card>

                <x-admin.card title="Fotos" help="La primera es la principal y la que aparece en las tarjetas. JPG, PNG o WebP de hasta 5 MB. Ideal: fondo blanco o transparente, 1200 × 900 px.">
                    @if ($product->images->isNotEmpty())
                        <div class="gallery-admin">
                            @foreach ($product->images as $image)
                                <div class="gallery-admin__item">
                                    <div class="gallery-admin__img">
                                        @if (file_exists(public_path($image->path)))
                                            <img src="{{ asset($image->path) }}" alt="">
                                        @else
                                            <i class="bi bi-image text-secondary" aria-hidden="true"></i>
                                        @endif
                                    </div>
                                    <label class="form-label small mb-1">Orden</label>
                                    <input type="number" min="0" name="gallery[{{ $image->id }}][sort_order]" value="{{ $image->sort_order }}" class="form-control mb-2">
                                    <label class="form-label small mb-1">Texto alternativo</label>
                                    <input type="text" name="gallery[{{ $image->id }}][alt]" value="{{ $image->alt }}" class="form-control mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gallery[{{ $image->id }}][remove]" value="1" id="remove-image-{{ $image->id }}">
                                        <label class="form-check-label text-danger" for="remove-image-{{ $image->id }}">Eliminar</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <label for="field-images" class="form-label">Agregar fotos</label>
                    <input type="file" id="field-images" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                        @class(['form-control', 'is-invalid' => $errors->has('images.*')])>
                    <div class="form-text">Puedes elegir varias a la vez.</div>
                </x-admin.card>

                <x-admin.card title="Tarjeta del catálogo" help="Los datos que aparecen en la tarjeta del listado de productos (recomendado: 4).">
                    <x-admin.pairs-repeater name="card_specs" :rows="old('card_specs', $product->card_specs ?? [])" />
                </x-admin.card>

                <x-admin.card title="Datos destacados" help="Aparecen junto a las fotos en la página del producto (recomendado: 4 o 5).">
                    <x-admin.pairs-repeater name="highlights" :rows="old('highlights', $product->highlights ?? [])" />
                </x-admin.card>

                <x-admin.card title="Ventajas" help="Bloques con ícono, título y texto (recomendado: 3).">
                    <div class="repeater" data-repeater data-placeholder="__FEATURE__">
                        <div class="repeater__items" data-repeater-items>
                            @foreach (array_values($features) as $i => $feature)
                                <div class="repeater__row repeater__row--stacked" data-repeater-item>
                                    <div class="repeater__fields">
                                        <input type="text" name="features[{{ $i }}][title]" value="{{ $feature['title'] ?? '' }}" class="form-control" placeholder="Título (ej. Eficiente y confiable)">
                                        <textarea name="features[{{ $i }}][text]" rows="2" class="form-control" placeholder="Texto">{{ $feature['text'] ?? '' }}</textarea>
                                    </div>
                                    <x-admin.repeater-controls />
                                </div>
                            @endforeach
                        </div>
                        <template data-repeater-template>
                            <div class="repeater__row repeater__row--stacked" data-repeater-item>
                                <div class="repeater__fields">
                                    <input type="text" name="features[__FEATURE__][title]" class="form-control" placeholder="Título (ej. Eficiente y confiable)">
                                    <textarea name="features[__FEATURE__][text]" rows="2" class="form-control" placeholder="Texto"></textarea>
                                </div>
                                <x-admin.repeater-controls />
                            </div>
                        </template>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeater-add>
                            <i class="bi bi-plus-lg" aria-hidden="true"></i> Agregar ventaja
                        </button>
                    </div>
                </x-admin.card>

                <x-admin.card title="Especificaciones técnicas" help="Agrupadas por tema (Motor, Dimensiones…). Cada grupo es una tabla en la página del producto.">
                    <div class="repeater" data-repeater data-placeholder="__GROUP__">
                        <div class="repeater__items" data-repeater-items>
                            @foreach (array_values($groups) as $g => $group)
                                <div class="repeater__group" data-repeater-item>
                                    <div class="repeater__group-header">
                                        <input type="text" name="spec_groups[{{ $g }}][title]" value="{{ $group['title'] ?? '' }}" class="form-control fw-semibold" placeholder="Nombre del grupo (ej. Motor)">
                                        <x-admin.repeater-controls />
                                    </div>
                                    <x-admin.pairs-repeater :name="'spec_groups['.$g.'][rows]'" :rows="$group['rows'] ?? []" placeholder="__ROW__" add-label="Agregar fila" />
                                </div>
                            @endforeach
                        </div>
                        <template data-repeater-template>
                            <div class="repeater__group" data-repeater-item>
                                <div class="repeater__group-header">
                                    <input type="text" name="spec_groups[__GROUP__][title]" class="form-control fw-semibold" placeholder="Nombre del grupo (ej. Motor)">
                                    <x-admin.repeater-controls />
                                </div>
                                <x-admin.pairs-repeater name="spec_groups[__GROUP__][rows]" :rows="[['label' => '', 'value' => '']]" placeholder="__ROW__" add-label="Agregar fila" />
                            </div>
                        </template>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeater-add>
                            <i class="bi bi-plus-lg" aria-hidden="true"></i> Agregar grupo
                        </button>
                    </div>
                </x-admin.card>
            </div>

            <div class="col-xl-4">
                <x-admin.card title="Publicación">
                    <x-admin.checkbox name="is_published" label="Visible en el sitio" :checked="$product->is_published" />
                    <x-forms.input class="mt-3" name="sort_order" type="number" min="0" label="Orden" :value="$product->sort_order ?? 0"
                        help="Los números menores aparecen primero." />
                </x-admin.card>

                <x-admin.card title="Clasificación">
                    <x-forms.select name="category_id" label="Categoría" :options="$categories->pluck('name', 'id')->all()"
                        :value="$product->category_id" placeholder="Elige una categoría" />

                    <div class="form-field mt-3">
                        <label for="field-product_type_id" class="form-label">Tipo de equipo</label>
                        <select id="field-product_type_id" name="product_type_id" data-depends-on="#field-category_id"
                            @class(['form-select', 'is-invalid' => $errors->has('product_type_id')])>
                            <option value="">Sin tipo</option>
                            @foreach ($categories as $category)
                                @foreach ($category->types as $type)
                                    <option value="{{ $type->id }}" data-parent="{{ $category->id }}"
                                        @selected((string) old('product_type_id', $product->product_type_id) === (string) $type->id)>{{ $type->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        <x-forms.error name="product_type_id" />
                        <div class="form-text">Los tipos se editan en <a href="{{ route('admin.categories.index') }}">Categorías y tipos</a>.</div>
                    </div>
                </x-admin.card>

                <x-admin.card title="Ficha técnica (PDF)">
                    <x-admin.image-input name="brochure" label="Archivo PDF" :current="$product->brochure" accept="application/pdf"
                        pdf remove-label="Quitar PDF actual" help="Hasta 10 MB. Aparece como enlace de descarga." />
                </x-admin.card>
            </div>
        </div>

        <div class="admin-form-actions">
            <x-ui.button :href="route('admin.products.index')" variant="light">Cancelar</x-ui.button>
            <x-ui.button type="submit"><i class="bi bi-check-lg" aria-hidden="true"></i> Guardar</x-ui.button>
        </div>
    </form>

    @if ($editing)
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="mt-4" data-confirm="¿Eliminar «{{ $product->name }}»? También se borran sus fotos.">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link text-danger p-0"><i class="bi bi-trash" aria-hidden="true"></i> Eliminar producto</button>
        </form>
    @endif
</x-layouts.admin>
