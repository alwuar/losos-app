{{--
    Filtros tipo "pill".
    :items  => ['slug' => 'Etiqueta', ...]
    :url    => fn (string $slug) => string
--}}
@props([
    'items' => [],
    'active' => null,
    'url',
    'label' => 'Filtrar',
])

<ul {{ $attributes->class(['filter-pills']) }} aria-label="{{ $label }}">
    @foreach ($items as $slug => $name)
        <li>
            <a href="{{ $url($slug) }}"
               @class(['filter-pills__item', 'is-active' => $slug === $active])
               @if ($slug === $active) aria-current="true" @endif>
                {{ $name }}
            </a>
        </li>
    @endforeach
</ul>
