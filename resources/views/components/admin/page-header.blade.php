{{-- Título de la página del panel + acciones a la derecha --}}
@props([
    'title',
    'back' => null,
])

<div {{ $attributes->class(['admin-page-header']) }}>
    <div>
        @if ($back)
            <a href="{{ $back }}" class="admin-page-header__back"><i class="bi bi-arrow-left" aria-hidden="true"></i> Volver</a>
        @endif
        <h1 class="admin-page-header__title">{{ $title }}</h1>
    </div>

    @isset($actions)
        <div class="admin-page-header__actions">{{ $actions }}</div>
    @endisset
</div>
