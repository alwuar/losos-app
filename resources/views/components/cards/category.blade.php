{{-- Tarjeta de línea de productos: imagen + panel naranja --}}
@props([
    'title',
    'label' => null,
    'image' => null,
    'href',
    'linkLabel' => 'Ver catálogo',
])

<article {{ $attributes->class(['category-card']) }}>
    <x-ui.media :src="$image" :alt="$title" class="category-card__media" />

    <div class="category-card__body">
        @if ($label)
            <p class="category-card__eyebrow">{{ $label }}</p>
        @endif

        <h3 class="category-card__title">{{ $title }}</h3>
        <p class="category-card__text">{{ $slot }}</p>

        <div class="category-card__link">
            <x-ui.link-arrow :href="$href" light>{{ $linkLabel }}</x-ui.link-arrow>
        </div>
    </div>
</article>
