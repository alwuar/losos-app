{{--
    "Marcas aliadas": carrusel infinito de logos (solo CSS, scss/components/_brands.scss).
    La lista se repite para cubrir pantallas anchas y se duplica para que el
    recorrido no tenga cortes; las copias se ocultan a lectores de pantalla.
--}}
@props([
    'brands' => [],
    'title' => 'Marcas aliadas',
    'minItems' => 12, // logos mínimos por vuelta para llenar 1920px
])

@php
    $brands = array_values($brands);
    $repeat = $brands ? (int) ceil($minItems / count($brands)) : 0;
    $items = collect(array_fill(0, $repeat, $brands))->flatten(1);
@endphp

<div {{ $attributes->class(['brand-strip']) }}>
    <h2 class="brand-strip__title" data-reveal="fade">{!! str_replace(' ', '<br>', e($title)) !!}</h2>

    @if ($brands)
        <div class="brand-strip__marquee" data-reveal="fade" style="--marquee-duration: {{ $items->count() * 2.5 }}s">
            <div class="brand-strip__track">
                @foreach ([false, true] as $isCopy)
                    <ul class="brand-strip__logos" @if ($isCopy) aria-hidden="true" @endif>
                        @foreach ($items as $index => $brand)
                            @php($hasLogo = ! empty($brand['logo']) && file_exists(public_path($brand['logo'])))
                            <li class="brand-strip__logo" @if (! $isCopy && $index >= count($brands)) aria-hidden="true" @endif>
                                <x-ui.media :src="$hasLogo ? $brand['logo'] : null" :alt="$isCopy ? '' : $brand['name']" fit="contain" />
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    @endif
</div>
