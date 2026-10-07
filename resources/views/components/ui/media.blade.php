{{--
    Imagen con relación de aspecto. Si el archivo aún no existe en /public
    se muestra el recuadro gris del diseño.

    <x-ui.media src="images/home/hero.jpg" alt="..." />
--}}
@props([
    'src' => null,
    'alt' => '',
    'fit' => 'cover', // cover | contain
    'rounded' => false,
    'loading' => 'lazy',
])

@php($exists = $src && (str_starts_with($src, 'http') || file_exists(public_path($src))))

<div {{ $attributes->class([
    'media',
    'media--contain' => $fit === 'contain',
    'media--rounded' => $rounded,
]) }}>
    @if ($exists)
        <img src="{{ str_starts_with($src, 'http') ? $src : asset($src) }}" alt="{{ $alt }}" loading="{{ $loading }}">
    @else
        <div class="media__placeholder" role="img" aria-label="{{ $alt }}"></div>
    @endif

    {{ $slot }}
</div>
