{{--
    Bloque de dos columnas: imagen (438px) + contenido.
    reverse: imagen a la derecha     accent: título naranja en mayúsculas
--}}
@props([
    'title',
    'eyebrow' => null,
    'image' => null,
    'imageAlt' => '',
    'reverse' => false,
    'accent' => false,
    'headingLevel' => 'h2',
    'actions' => null,
])

<div {{ $attributes->class(['split', 'split--reverse' => $reverse, 'split--accent' => $accent]) }}>
    <x-ui.media :src="$image" :alt="$imageAlt ?: $title" class="split__media" />

    <div class="split__content">
        @if ($eyebrow)
            <p class="split__eyebrow">{{ $eyebrow }}</p>
        @endif

        <{{ $headingLevel }} class="split__title">{{ $title }}</{{ $headingLevel }}>

        <div class="split__body">
            {{ $slot }}
        </div>

        @if ($actions)
            <div class="split__actions">{{ $actions }}</div>
        @endif
    </div>
</div>
