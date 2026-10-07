<x-layouts.admin title="Imágenes del sitio">
    <x-admin.page-header title="Imágenes del sitio" />

    <p class="text-secondary small mb-4">
        Fotos fijas de las secciones. Al subir una nueva se reemplaza en el sitio de inmediato.
        Las imágenes de las categorías se cambian en <a href="{{ route('admin.categories.index') }}">Categorías</a>
        y las de los equipos en <a href="{{ route('admin.products.index') }}">Productos</a>.
    </p>

    <div class="row g-4">
        @foreach ($images as $image)
            @php($current = \App\Models\SiteImage::path($image->key))
            <div class="col-md-6">
                <x-admin.card :title="$image->label" :help="$image->help" class="h-100 mb-0">
                    <div class="site-image-preview mb-3">
                        @if ($current && file_exists(public_path($current)))
                            <img src="{{ asset($current) }}" alt="">
                        @else
                            <span><i class="bi bi-image" aria-hidden="true"></i> Sin imagen (se muestra un recuadro gris)</span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.site-images.update', $image) }}" enctype="multipart/form-data" class="d-flex gap-2">
                        @csrf
                        @method('PUT')
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="form-control" required aria-label="Nueva imagen para {{ $image->label }}">
                        <x-ui.button type="submit">Subir</x-ui.button>
                    </form>

                    @if ($image->path)
                        <form method="POST" action="{{ route('admin.site-images.destroy', $image) }}" class="mt-2" data-confirm="¿Volver a la imagen original?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link btn-sm p-0 text-secondary">Volver a la imagen original</button>
                        </form>
                    @endif
                </x-admin.card>
            </div>
        @endforeach
    </div>
</x-layouts.admin>
