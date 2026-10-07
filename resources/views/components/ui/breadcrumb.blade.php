{{--
    Ruta de navegación.
    :items => [['label' => 'Productos', 'url' => '...'], ..., ['label' => 'Actual']]
--}}
@props(['items' => []])

<nav {{ $attributes->class(['breadcrumb-bar']) }} aria-label="Ruta de navegación">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>

            @foreach ($items as $item)
                @if ($loop->last || empty($item['url']))
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>
