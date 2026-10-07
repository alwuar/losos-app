{{-- Ícono + título + texto. Opcionalmente un enlace al final. tone: ink | navy --}}
@props([
    'title',
    'icon' => 'shield-check',
    'href' => null,
    'linkLabel' => 'Ver catálogo',
    'tone' => 'ink',
])

<article {{ $attributes->class(['feature-card', 'feature-card--navy' => $tone === 'navy']) }}>
    <x-ui.icon :name="$icon" class="feature-card__icon" />
    <h3 class="feature-card__title">{{ $title }}</h3>
    <p class="feature-card__text">{{ $slot }}</p>

    @if ($href)
        <div class="feature-card__link">
            <x-ui.link-arrow :href="$href">{{ $linkLabel }}</x-ui.link-arrow>
        </div>
    @endif
</article>
