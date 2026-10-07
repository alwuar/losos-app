@props(['path' => null])

<span {{ $attributes->class(['admin-table__thumb']) }}>
    @if ($path && file_exists(public_path($path)))
        <img src="{{ asset($path) }}" alt="" loading="lazy">
    @else
        <i class="bi bi-image" aria-hidden="true"></i>
    @endif
</span>
