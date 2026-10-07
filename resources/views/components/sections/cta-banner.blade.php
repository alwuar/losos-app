{{-- Banda naranja de cierre. align: start | center    compact: versión de 216px --}}
@props([
    'title',
    'align' => 'start',
    'compact' => false,
    'actions' => null,
])

<section {{ $attributes->class(['cta-banner', 'cta-banner--center' => $align === 'center', 'cta-banner--compact' => $compact]) }}>
    <div class="container">
        <h2 class="cta-banner__title" data-reveal="up">{{ $title }}</h2>

        @if ($slot->isNotEmpty())
            <p class="cta-banner__text" data-reveal="up">{{ $slot }}</p>
        @endif

        @if ($actions)
            <div class="cta-banner__actions" data-reveal="up">{{ $actions }}</div>
        @endif
    </div>
</section>
