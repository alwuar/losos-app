{{--
    Encabezado de sección: eyebrow + título de 26px.
    align: start | center      uppercase: título en mayúsculas
--}}
@props([
    'eyebrow' => null,
    'title',
    'align' => 'start',
    'uppercase' => false,
    'as' => 'h2',
])

<header {{ $attributes->class([
    'section-heading',
    'section-heading--center' => $align === 'center',
    'section-heading--uppercase' => $uppercase,
]) }}>
    @if ($eyebrow)
        <x-ui.eyebrow>{{ $eyebrow }}</x-ui.eyebrow>
    @endif

    <{{ $as }} class="section-heading__title title-section">{{ $title }}</{{ $as }}>
</header>
