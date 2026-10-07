@php($editing = $brand->exists)

<x-layouts.admin :title="$editing ? $brand->name : 'Nueva marca'">
    <x-admin.page-header :title="$editing ? $brand->name : 'Nueva marca'" :back="route('admin.brands.index')" />

    <form method="POST" enctype="multipart/form-data" class="admin-form"
          action="{{ $editing ? route('admin.brands.update', $brand) : route('admin.brands.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <x-admin.card style="max-width: 720px">
            <div class="row g-3">
                <x-forms.input class="col-md-8" name="name" label="Nombre" :value="$brand->name" required />
                <x-forms.input class="col-md-4" name="sort_order" type="number" min="0" label="Orden" :value="$brand->sort_order ?? 0" />
                <x-admin.image-input class="col-12" name="logo" label="Logo" :current="$brand->logo" accept="image/png,image/jpeg,image/webp"
                    help="PNG con fondo transparente, 400 × 160 px aprox. Hasta 2 MB." remove-label="Quitar logo" />
                <x-admin.checkbox class="col-12" name="is_active" label="Visible en el sitio" :checked="$brand->is_active" />
            </div>
        </x-admin.card>

        <div class="admin-form-actions">
            <x-ui.button :href="route('admin.brands.index')" variant="light">Cancelar</x-ui.button>
            <x-ui.button type="submit"><i class="bi bi-check-lg" aria-hidden="true"></i> Guardar</x-ui.button>
        </div>
    </form>
</x-layouts.admin>
