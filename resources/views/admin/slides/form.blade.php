@php($editing = $slide->exists)
@php($heading = $editing ? 'Editar diapositiva' : 'Nueva diapositiva')

<x-layouts.admin :title="$heading">
    <x-admin.page-header :title="$heading" :back="route('admin.slides.index')" />

    <form method="POST" enctype="multipart/form-data" class="admin-form"
          action="{{ $editing ? route('admin.slides.update', $slide) : route('admin.slides.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-xl-8">
                <x-admin.card title="Contenido">
                    <div class="row g-3">
                        <x-admin.image-input class="col-12" name="image" label="Imagen de fondo" :current="$slide->image" :removable="false"
                            help="JPG horizontal de 1920 × 840 px aprox. Hasta 8 MB. El texto va al centro: evita fotos con el motivo principal justo ahí." />
                        <x-admin.textarea class="col-12" name="title" label="Título" :value="$slide->title" rows="2" maxlength="140" required
                            help="Usa Enter para partir el título en dos líneas (solo en pantallas grandes)." />
                        <x-admin.textarea class="col-12" name="text" label="Texto" :value="$slide->text" rows="3" maxlength="400" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Botones" help="Opcionales. Para una página del sitio escribe la ruta (/productos, /contacto); para otro sitio, la dirección completa (https://…)." class="mt-4">
                    <div class="row g-3">
                        <x-forms.input class="col-md-5" name="primary_label" label="Botón 1 · texto" :value="$slide->primary_label" placeholder="Ver catálogo" maxlength="40" />
                        <x-forms.input class="col-md-7" name="primary_url" label="Botón 1 · enlace" :value="$slide->primary_url" placeholder="/productos" />
                        <x-forms.input class="col-md-5" name="secondary_label" label="Botón 2 · texto" :value="$slide->secondary_label" placeholder="Contáctanos" maxlength="40" />
                        <x-forms.input class="col-md-7" name="secondary_url" label="Botón 2 · enlace" :value="$slide->secondary_url" placeholder="/contacto" />
                    </div>
                </x-admin.card>
            </div>

            <div class="col-xl-4">
                <x-admin.card title="Publicación">
                    <div class="row g-3">
                        <x-admin.checkbox class="col-12" name="is_active" label="Visible en el sitio" :checked="$slide->is_active" />
                        <x-forms.input class="col-12" name="sort_order" type="number" min="0" label="Orden" :value="$slide->sort_order ?? 0"
                            help="Las diapositivas se muestran de menor a mayor." />
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="admin-form-actions">
            <x-ui.button :href="route('admin.slides.index')" variant="light">Cancelar</x-ui.button>
            <x-ui.button type="submit"><i class="bi bi-check-lg" aria-hidden="true"></i> Guardar</x-ui.button>
        </div>
    </form>
</x-layouts.admin>
