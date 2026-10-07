@php
    $items = [
        ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Inicio'],
        ['route' => 'admin.products.index', 'match' => 'admin.products.*', 'icon' => 'bi-truck', 'label' => 'Productos'],
        ['route' => 'admin.categories.index', 'match' => 'admin.categories.*', 'icon' => 'bi-grid', 'label' => 'Categorías y tipos'],
        ['route' => 'admin.brands.index', 'match' => 'admin.brands.*', 'icon' => 'bi-award', 'label' => 'Marcas'],
        ['route' => 'admin.site-images.index', 'match' => 'admin.site-images.*', 'icon' => 'bi-images', 'label' => 'Imágenes del sitio'],
    ];
@endphp

<nav class="admin-nav" aria-label="Panel">
    @foreach ($items as $item)
        @php($active = request()->routeIs($item['match']))
        <a href="{{ route($item['route']) }}" @class(['admin-nav__link', 'is-active' => $active]) @if ($active) aria-current="page" @endif>
            <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i> {{ $item['label'] }}
        </a>
    @endforeach
</nav>
