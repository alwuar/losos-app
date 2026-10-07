{{--
    Botón / enlace con estilo de botón.
    variant: primary | outline-light | outline-primary | navy
    size:    sm | md | lg
--}}
@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $classes = [
        'btn',
        'btn-'.$variant,
        'btn-sm' => $size === 'sm',
        'btn-lg' => $size === 'lg',
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
