<x-layouts.admin title="Marcas">
    <x-admin.page-header title="Marcas">
        <x-slot:actions>
            <x-ui.button :href="route('admin.brands.create')"><i class="bi bi-plus-lg" aria-hidden="true"></i> Nueva marca</x-ui.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card help="Aparecen en «Marcas aliadas» (Inicio) y en «Trabajamos con líderes mundiales» (Quiénes somos). Sin logo se muestra el nombre.">
        @if ($brands->isEmpty())
            <div class="admin-empty"><i class="bi bi-award" aria-hidden="true"></i>Aún no hay marcas.</div>
        @else
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px">Logo</th>
                            <th>Marca</th>
                            <th>Estado</th>
                            <th class="text-end">Orden</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td><x-admin.thumb :path="$brand->logo" /></td>
                                <td><a href="{{ route('admin.brands.edit', $brand) }}" class="admin-table__name">{{ $brand->name }}</a></td>
                                <td>
                                    <span @class(['badge-status', 'badge-status--on' => $brand->is_active, 'badge-status--off' => ! $brand->is_active])>
                                        {{ $brand->is_active ? 'Visible' : 'Oculta' }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $brand->sort_order }}</td>
                                <td>
                                    <div class="admin-table__actions">
                                        <x-ui.button :href="route('admin.brands.edit', $brand)" variant="outline-secondary" size="sm">Editar</x-ui.button>
                                        <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" data-confirm="¿Eliminar la marca «{{ $brand->name }}»?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Eliminar {{ $brand->name }}"><i class="bi bi-trash" aria-hidden="true"></i></button>
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
