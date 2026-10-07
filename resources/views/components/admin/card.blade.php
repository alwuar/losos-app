{{-- Bloque blanco del panel con título opcional --}}
@props([
    'title' => null,
    'help' => null,
])

<section {{ $attributes->class(['admin-card']) }}>
    @if ($title)
        <header class="admin-card__header">
            <h2 class="admin-card__title">{{ $title }}</h2>
            @if ($help)
                <p class="admin-card__help">{{ $help }}</p>
            @endif
        </header>
    @endif

    <div class="admin-card__body">
        {{ $slot }}
    </div>
</section>
