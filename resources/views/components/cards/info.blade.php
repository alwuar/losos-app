{{-- Tarjeta blanca con sombra (misión, visión, ubicaciones) --}}
@props([
    'title',
    'icon' => null,
])

<article {{ $attributes->class(['info-card']) }}>
    @if ($icon)
        <x-ui.icon :name="$icon" class="info-card__icon" />
    @endif

    <h3 class="info-card__title">{{ $title }}</h3>

    <div class="info-card__body">
        {{ $slot }}
    </div>
</article>
