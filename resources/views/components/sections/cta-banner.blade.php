{{-- Banda naranja de cierre. align: start | center    compact: versión de 216px --}}
@props([
    'title',
    'align' => 'start',
    'compact' => false,
    'actions' => null,
])

<section {{ $attributes->class(['cta-banner', 'cta-banner--center' => $align === 'center', 'cta-banner--compact' => $compact]) }}>
    <div class="container">
        <h2 class="cta-banner__title">{{ $title }}</h2>

        @if ($slot->isNotEmpty())
            <p class="cta-banner__text">{{ $slot }}</p>
        @endif

        @if ($actions)
            <div class="cta-banner__actions">{{ $actions }}</div>
        @endif
    </div>
</section>
