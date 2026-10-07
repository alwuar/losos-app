{{--
    Envoltorio de sección con contenedor. variant: default | surface | navy
    El espaciado vertical lo pone la clase de cada página (pages/_*.scss).
--}}
@props([
    'variant' => 'default',
    'container' => true,
])

<section {{ $attributes->class([
    'section',
    'section--'.$variant => $variant !== 'default',
]) }}>
    @if ($container)
        <div class="container">{{ $slot }}</div>
    @else
        {{ $slot }}
    @endif
</section>
