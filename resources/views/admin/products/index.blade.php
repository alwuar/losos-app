<x-layouts.admin title="Productos">
    <x-admin.page-header title="Productos">
        <x-slot:actions>
            <x-ui.button :href="route('admin.products.create')"><i class="bi bi-plus-lg" aria-hidden="true"></i> Nuevo producto</x-ui.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card>
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por nombre…">
            </div>
            <div class="col-md-4">
                <select name="categoria" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) request('categoria') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <x-ui.button type="submit" variant="outline-secondary" class="w-100">Filtrar</x-ui.button>
            </div>
        </form>

        @if ($products->isEmpty())
            <div class="admin-empty">
                <i class="bi bi-truck" aria-hidden="true"></i>
                No hay productos{{ request()->hasAny(['q', 'categoria']) ? ' con ese filtro' : ' todavía' }}.
            </div>
        @else
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px"></th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th class="text-end">Orden</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td><x-admin.thumb :path="$product->coverImage()" /></td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="admin-table__name">{{ $product->name }}</a>
                                    @if ($product->brand)
                                        <div class="small text-secondary">{{ $product->brand }}</div>
                                    @endif
                                </td>
                                <td>
                                    {{ $product->category->name }}
                                    @if ($product->type)
                                        <div class="small text-secondary">{{ $product->type->name }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span @class(['badge-status', 'badge-status--on' => $product->is_published, 'badge-status--off' => ! $product->is_published])>
                                        {{ $product->is_published ? 'Publicado' : 'Oculto' }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $product->sort_order }}</td>
                                <td>
                                    <div class="admin-table__actions">
                                        <x-ui.button :href="route('admin.products.edit', $product)" variant="outline-secondary" size="sm">Editar</x-ui.button>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-confirm="¿Eliminar «{{ $product->name }}»? También se borran sus fotos.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Eliminar {{ $product->name }}"><i class="bi bi-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $products->links() }}
        @endif
    </x-admin.card>
</x-layouts.admin>
