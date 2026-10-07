{{--
    Encabezado de Inicio. Recibe las diapositivas de Catalog::heroSlides():
    [['image', 'title', 'text', 'buttons' => [['label', 'url', 'variant', 'external']]], ...]

    Con una sola diapositiva es una imagen fija; con dos o más se convierte en
    slider (Carousel de Bootstrap, resources/js/modules/hero-slider.js).
--}}
@props([
    'slides' => [],
    'interval' => 6000, // milisegundos por diapositiva
])

@php
    $slides = collect($slides)->values();
    $isSlider = $slides->count() > 1;
    $id = 'hero-slider';
@endphp

<section
    {{ $attributes->class(['hero', 'hero--slider carousel slide carousel-fade' => $isSlider]) }}
    @if ($isSlider)
        id="{{ $id }}"
        data-hero-slider
        data-interval="{{ $interval }}"
        aria-roledescription="carrusel"
        aria-label="Destacados"
    @endif
>
    <div @class(['hero__slides', 'carousel-inner' => $isSlider])>
        @foreach ($slides as $index => $slide)
            @php($heading = $index === 0 ? 'h1' : 'h2')
            @php($reveal = $isSlider ? null : 'up') {{-- en el slider anima el CSS de la diapositiva activa --}}

            <div
                @class(['hero__slide', 'carousel-item' => $isSlider, 'active' => $isSlider && $index === 0])
                @if ($isSlider) role="group" aria-roledescription="diapositiva" aria-label="{{ $index + 1 }} de {{ $slides->count() }}" @endif
            >
                @if ($slide['image'] && (str_starts_with($slide['image'], 'http') || file_exists(public_path($slide['image']))))
                    <div class="hero__bg">
                        <img
                            src="{{ str_starts_with($slide['image'], 'http') ? $slide['image'] : asset($slide['image']) }}"
                            alt=""
                            @if ($index === 0) fetchpriority="high" @else loading="lazy" @endif
                        >
                    </div>
                @endif

                <div class="container">
                    <div class="hero__content">
                        <{{ $heading }} class="hero__title" @if ($reveal) data-reveal="{{ $reveal }}" @endif>
                            {!! str_replace("\n", ' <br class="br-lg">', e(str_replace("\r\n", "\n", trim($slide['title'])))) !!}
                        </{{ $heading }}>

                        @if (filled($slide['text'] ?? null))
                            <p class="hero__text" @if ($reveal) data-reveal="{{ $reveal }}" @endif>{{ $slide['text'] }}</p>
                        @endif

                        @if (! empty($slide['buttons']))
                            <div class="hero__actions" @if ($reveal) data-reveal="{{ $reveal }}" @endif>
                                @foreach ($slide['buttons'] as $button)
                                    <x-ui.button
                                        :href="$button['url']"
                                        :variant="$button['variant']"
                                        size="lg"
                                        :target="$button['external'] ? '_blank' : null"
                                        :rel="$button['external'] ? 'noopener' : null">
                                        {{ $button['label'] }}
                                    </x-ui.button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($isSlider)
        <button class="hero__arrow hero__arrow--prev" type="button" data-bs-target="#{{ $id }}" data-bs-slide="prev">
            <i class="bi bi-chevron-left" aria-hidden="true"></i>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="hero__arrow hero__arrow--next" type="button" data-bs-target="#{{ $id }}" data-bs-slide="next">
            <i class="bi bi-chevron-right" aria-hidden="true"></i>
            <span class="visually-hidden">Siguiente</span>
        </button>

        <div class="hero__dots carousel-indicators">
            @foreach ($slides as $index => $slide)
                <button type="button" data-bs-target="#{{ $id }}" data-bs-slide-to="{{ $index }}"
                    @class(['active' => $index === 0])
                    @if ($index === 0) aria-current="true" @endif
                    aria-label="Ir a la diapositiva {{ $index + 1 }}"></button>
            @endforeach
        </div>
    @endif
</section>
