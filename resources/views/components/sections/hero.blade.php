{{--
    Hero principal con imagen de fondo (inicio).
    El título va en el slot "title" para poder controlar el salto de línea.
--}}
@props([
    'title',
    'image' => null,
    'actions' => null,
])

<section {{ $attributes->class(['hero']) }}>
    @if ($image && file_exists(public_path($image)))
        <div class="hero__bg">
            <img src="{{ asset($image) }}" alt="" fetchpriority="high">
        </div>
    @endif

    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title">{{ $title }}</h1>

            @if ($slot->isNotEmpty())
                <p class="hero__text">{{ $slot }}</p>
            @endif

            @if ($actions)
                <div class="hero__actions">{{ $actions }}</div>
            @endif
        </div>
    </div>
</section>
