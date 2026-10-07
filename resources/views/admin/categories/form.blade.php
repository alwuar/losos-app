@php
    $editing = $category->exists;
    $benefits = old('benefits', collect($category->benefits ?? [])->map(fn ($text) => ['text' => $text])->all());
    $types = old('types', $category->types?->map(fn ($type) => ['id' => $type->id, 'name' => $type->name])->all() ?? []);
@endphp

<x-layouts.admin :title="$editing ? $category->name : 'Nueva categoría'">
    <x-admin.page-header :title="$editing ? $category->name : 'Nueva categoría'" :back="route('admin.categories.index')" />

    <form method="POST" enctype="multipart/form-data" class="admin-form"
          action="{{ $editing ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-xl-8">
                <x-admin.card title="Datos de la categoría">
                    <div class="row g-3">
                        <x-forms.input class="col-md-8" name="name" label="Nombre" :value="$category->name" placeholder="Maquinaria Muevetierra" required />
                        <x-forms.input class="col-md-4" name="sort_order" type="number" min="0" label="Orden" :value="$category->sort_order ?? 0" />
                        <x-forms.input class="col-12" name="summary" label="Resumen (pestaña de Productos)" :value="$category->summary"
                            placeholder="Excavadoras · Cargadores · Retroexcavadoras" />
                        <x-admin.textarea class="col-12" name="description" label="Descripción (sección Beneficios)" :value="$category->description" />
                        <x-forms.input class="col-12" name="slug" label="URL (opcional)" :value="$category->slug" help="Se genera con el nombre." />
                    </div>
                </x-admin.card>

                <x-admin.card title="Tipos de equipo" help="Son los filtros del catálogo (Excavadoras, Cargadores…). Si quitas un tipo, sus productos quedan sin tipo.">
                    <div class="repeater" data-repeater data-placeholder="__TYPE__">
                        <div class="repeater__items" data-repeater-items>
                            @foreach (array_values($types) as $i => $type)
                                <div class="repeater__row repeater__row--single" data-repeater-item>
                                    <div>
                                        <input type="hidden" name="types[{{ $i }}][id]" value="{{ $type['id'] ?? '' }}">
                                        <input type="text" name="types[{{ $i }}][name]" value="{{ $type['name'] ?? '' }}" class="form-control" placeholder="Nombre del tipo">
                                    </div>
                                    <x-admin.repeater-controls />
                                </div>
                            @endforeach
                        </div>
                        <template data-repeater-template>
                            <div class="repeater__row repeater__row--single" data-repeater-item>
                                <div><input type="text" name="types[__TYPE__][name]" class="form-control" placeholder="Nombre del tipo"></div>
                                <x-admin.repeater-controls />
                            </div>
                        </template>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeater-add><i class="bi bi-plus-lg" aria-hidden="true"></i> Agregar tipo</button>
                    </div>
                </x-admin.card>

                <x-admin.card title="Beneficios" help="Lista con palomitas en la página de Productos (recomendado: 3).">
                    <div class="repeater" data-repeater data-placeholder="__BENEFIT__">
                        <div class="repeater__items" data-repeater-items>
                            @foreach (array_values($benefits) as $i => $benefit)
                                <div class="repeater__row repeater__row--single" data-repeater-item>
                                    <input type="text" name="benefits[{{ $i }}][text]" value="{{ $benefit['text'] ?? '' }}" class="form-control" placeholder="Alta durabilidad y resistencia">
                                    <x-admin.repeater-controls />
                                </div>
                            @endforeach
                        </div>
                        <template data-repeater-template>
                            <div class="repeater__row repeater__row--single" data-repeater-item>
                                <input type="text" name="benefits[__BENEFIT__][text]" class="form-control" placeholder="Alta durabilidad y resistencia">
                                <x-admin.repeater-controls />
                            </div>
                        </template>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeater-add><i class="bi bi-plus-lg" aria-hidden="true"></i> Agregar beneficio</button>
                    </div>
                </x-admin.card>
            </div>

            <div class="col-xl-4">
                <x-admin.card title="Tarjeta en Inicio" help="Sección «Línea de productos».">
                    <x-admin.image-input name="image" label="Imagen" :current="$category->image"
                        help="Vertical u horizontal, 800 × 800 px aprox. JPG o WebP." />
                    <div class="row g-3 mt-1">
                        <x-forms.input class="col-12" name="label" label="Etiqueta" :value="$category->label" placeholder="Categoría" />
                        <x-forms.input class="col-12" name="card_title" label="Título en la tarjeta (opcional)" :value="$category->card_title"
                            help="Si lo dejas vacío se usa el nombre." />
                        <x-admin.textarea class="col-12" name="excerpt" label="Texto de la tarjeta" :value="$category->excerpt" rows="3" />
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="admin-form-actions">
            <x-ui.button :href="route('admin.categories.index')" variant="light">Cancelar</x-ui.button>
            <x-ui.button type="submit"><i class="bi bi-check-lg" aria-hidden="true"></i> Guardar</x-ui.button>
        </div>
    </form>
</x-layouts.admin>
