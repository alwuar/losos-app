<x-layouts.admin title="Inicio">
    <x-admin.page-header title="Hola, {{ auth()->user()->name }}">
        <x-slot:actions>
            <x-ui.button :href="route('admin.products.create')"><i class="bi bi-plus-lg" aria-hidden="true"></i> Nuevo producto</x-ui.button>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="admin-stats">
        @foreach ($stats as $stat)
            <a href="{{ route($stat['route']) }}" class="admin-stat">
                <i class="bi {{ $stat['icon'] }}" aria-hidden="true"></i>
                <span>
                    <span class="admin-stat__value">{{ $stat['value'] }}</span>
                    <span class="admin-stat__label">{{ $stat['label'] }}</span>
                </span>
            </a>
        @endforeach
    </div>

    <x-admin.card title="Últimos productos editados">
        @if ($latest->isEmpty())
            <div class="admin-empty"><i class="bi bi-truck" aria-hidden="true"></i>Aún no hay productos.</div>
        @else
            <div class="table-responsive">
                <table class="table admin-table">
                    <tbody>
                        @foreach ($latest as $product)
                            <tr>
                                <td style="width: 80px"><x-admin.thumb :path="$product->coverImage()" /></td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="admin-table__name">{{ $product->name }}</a>
                                    <div class="small text-secondary">{{ $product->category->name }}</div>
                                </td>
                                <td class="text-secondary small text-end">Editado {{ $product->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-admin.card>

    <x-admin.card title="¿Qué se administra aquí?">
        <ul class="mb-0 small">
            <li><strong>Productos:</strong> datos, fotos, ficha técnica y PDF de cada equipo.</li>
            <li><strong>Categorías y tipos:</strong> líneas de producto (Maquinaria Muevetierra, Equipo Industrial) y sus tipos (Excavadoras, Cargadores…).</li>
            <li><strong>Marcas:</strong> logos de "Marcas aliadas" y "Trabajamos con líderes mundiales".</li>
            <li><strong>Imágenes del sitio:</strong> foto principal de Inicio, Nuestra historia y Servicios.</li>
        </ul>
    </x-admin.card>
</x-layouts.admin>
