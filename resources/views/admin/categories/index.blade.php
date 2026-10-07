<x-layouts.admin title="Categorías y tipos">
    <x-admin.page-header title="Categorías y tipos">
        <x-slot:actions>
            <x-ui.button :href="route('admin.categories.create')"><i class="bi bi-plus-lg" aria-hidden="true"></i> Nueva categoría</x-ui.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card>
        @if ($categories->isEmpty())
            <div class="admin-empty"><i class="bi bi-grid" aria-hidden="true"></i>Aún no hay categorías.</div>
        @else
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px"></th>
                            <th>Categoría</th>
                            <th>Tipos</th>
                            <th class="text-end">Productos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td><x-admin.thumb :path="$category->image" /></td>
                                <td><a href="{{ route('admin.categories.edit', $category) }}" class="admin-table__name">{{ $category->name }}</a></td>
                                <td class="small">{{ $category->types->pluck('name')->join(', ') ?: '—' }}</td>
                                <td class="text-end">{{ $category->products_count }}</td>
                                <td>
                                    <div class="admin-table__actions">
                                        <x-ui.button :href="route('admin.categories.edit', $category)" variant="outline-secondary" size="sm">Editar</x-ui.button>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" data-confirm="¿Eliminar la categoría «{{ $category->name }}»?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Eliminar {{ $category->name }}"><i class="bi bi-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-admin.card>
</x-layouts.admin>
