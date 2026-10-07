{{-- Selector de categoría de la página de productos --}}
@props([
    'title',
    'href',
    'active' => false,
])

<a href="{{ $href }}"
   {{ $attributes->class(['category-tab', 'is-active' => $active]) }}
   @if ($active) aria-current="page" @endif>
    <span>
        <span class="category-tab__title d-block">{{ $title }}</span>
        <span class="category-tab__text d-block">{{ $slot }}</span>
    </span>

    @if ($active)
        <span class="category-tab__badge">Viendo</span>
    @endif
</a>
