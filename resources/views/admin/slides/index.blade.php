<x-layouts.admin title="Slider de inicio">
    <x-admin.page-header title="Slider de inicio">
        <x-slot:actions>
            <x-ui.button :href="route('admin.slides.create')"><i class="bi bi-plus-lg" aria-hidden="true"></i> Nueva diapositiva</x-ui.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card
        title="Encabezado de la página de Inicio"
        :help="match (true) {
            $activeCount === 0 => 'No hay diapositivas visibles: el sitio muestra el encabezado original.',
            $activeCount === 1 => 'Hay 1 diapositiva visible: se muestra como imagen fija. Con 2 o más se convierte en slider.',
            default => 'Hay '.$activeCount.' diapositivas visibles: se muestran como slider en el orden indicado.',
        }">
        @if ($slides->isEmpty())
            <div class="admin-empty"><i class="bi bi-collection" aria-hidden="true"></i>Aún no hay diapositivas.</div>
        @else
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th style="width: 120px">Imagen</th>
                            <th>Título</th>
                            <th>Botones</th>
                            <th>Estado</th>
                            <th class="text-end">Orden</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slides as $slide)
                            <tr>
                                <td><x-admin.thumb :path="$slide->image" class="admin-table__thumb--wide" /></td>
                                <td>
                                    <a href="{{ route('admin.slides.edit', $slide) }}" class="admin-table__name">{{ Str::squish($slide->title) }}</a>
                                    @if ($slide->text)
                                        <div class="small text-secondary">{{ Str::limit($slide->text, 90) }}</div>
                                    @endif
                                </td>
                                <td class="small">
                                    {{ collect($slide->buttons())->pluck('label')->implode(' · ') ?: '—' }}
                                </td>
                                <td>
                                    <span @class(['badge-status', 'badge-status--on' => $slide->is_active, 'badge-status--off' => ! $slide->is_active])>
                                        {{ $slide->is_active ? 'Visible' : 'Oculta' }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $slide->sort_order }}</td>
                                <td>
                                    <div class="admin-table__actions">
                                        <x-ui.button :href="route('admin.slides.edit', $slide)" variant="outline-secondary" size="sm">Editar</x-ui.button>
                                        <form method="POST" action="{{ route('admin.slides.destroy', $slide) }}" data-confirm="¿Eliminar la diapositiva «{{ Str::squish($slide->title) }}»?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Eliminar diapositiva"><i class="bi bi-trash" aria-hidden="true"></i></button>
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
